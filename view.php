<?php
// This file is part of the linkedincert module for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Handles viewing a linkedincert.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$id = required_param('id', PARAM_INT);
$downloadown = optional_param('downloadown', false, PARAM_BOOL);
$downloadtable = optional_param('download', null, PARAM_ALPHA);
$downloadissue = optional_param('downloadissue', 0, PARAM_INT);
$deleteissue = optional_param('deleteissue', 0, PARAM_INT);
$confirm = optional_param('confirm', false, PARAM_BOOL);
$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', \mod_linkedincert\certificate::linkedincert_PER_PAGE, PARAM_INT);

$cm = get_coursemodule_from_id('linkedincert', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$linkedincert = $DB->get_record('linkedincert', array('id' => $cm->instance), '*', MUST_EXIST);


// Ensure the user is allowed to view this page.
require_login($course, false, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/linkedincert:view', $context);

$canreceive = has_capability('mod/linkedincert:receiveissue', $context);
$canmanage = has_capability('mod/linkedincert:manage', $context);
$canviewreport = has_capability('mod/linkedincert:viewreport', $context);

// Initialise $PAGE.
$pageurl = new moodle_url('/mod/linkedincert/view.php', array('id' => $cm->id));
\mod_linkedincert\page_helper::page_setup($pageurl, $context, format_string($linkedincert->name));

// Check if the user can view the certificate based on time spent in course.
if ($linkedincert->requiredtime && !$canmanage) {
    if (\mod_linkedincert\certificate::get_course_time($course->id) < ($linkedincert->requiredtime * 60)) {
        $a = new stdClass;
        $a->requiredtime = $linkedincert->requiredtime;
        notice(get_string('requiredtimenotmet', 'linkedincert', $a), "$CFG->wwwroot/course/view.php?id=$course->id");
        die;
    }
}

// Check if we are deleting an issue.
if ($deleteissue && $canmanage && confirm_sesskey()) {
    if (!$confirm) {
        $nourl = new moodle_url('/mod/linkedincert/view.php', ['id' => $id]);
        $yesurl = new moodle_url('/mod/linkedincert/view.php',
            [
                'id' => $id,
                'deleteissue' => $deleteissue,
                'confirm' => 1,
                'sesskey' => sesskey()
            ]
        );

        // Show a confirmation page.
        $PAGE->navbar->add(get_string('deleteconfirm', 'linkedincert'));
        $message = get_string('deleteissueconfirm', 'linkedincert');
        echo $OUTPUT->header();
        echo $OUTPUT->heading(format_string($linkedincert->name));
        echo $OUTPUT->confirm($message, $yesurl, $nourl);
        echo $OUTPUT->footer();
        exit();
    }

    // Delete the issue.
    $DB->delete_records('linkedincert_issues', array('id' => $deleteissue, 'linkedincertid' => $linkedincert->id));

    // Redirect back to the manage templates page.
    redirect(new moodle_url('/mod/linkedincert/view.php', array('id' => $id)));
}

$event = \mod_linkedincert\event\course_module_viewed::create(array(
    'objectid' => $linkedincert->id,
    'context' => $context,
));
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('linkedincert', $linkedincert);
$event->trigger();


// Get the current groups mode.
if ($groupmode = groups_get_activity_groupmode($cm)) {
    groups_get_activity_group($cm, true);
}

// Generate the table to the report if there are issues to display.
if ($canviewreport) {
    // Get the total number of issues.
    $reporttable = new \mod_linkedincert\report_table($linkedincert->id, $cm, $groupmode, $downloadtable);
    $reporttable->define_baseurl($pageurl);

    if ($reporttable->is_downloading()) {
        $reporttable->download();
        exit();
    }
}

// Generate the intro content if it exists.
$intro = '';
if (!empty($linkedincert->intro)) {
    $intro = $OUTPUT->box(format_module_intro('linkedincert', $linkedincert, $cm->id), 'generalbox', 'intro');
}

if ($canreceive) {
    // Set the userid value of who we are downloading the certificate for.
    $userid = $USER->id;
    // Create new linkedincert issue record if one does not already exist.
    if (!$DB->record_exists('linkedincert_issues', array('userid' => $USER->id, 'linkedincertid' => $linkedincert->id))) {
        \mod_linkedincert\certificate::issue_certificate($linkedincert->id, $USER->id);
    }

    // Set the custom certificate as viewed.
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}

// If the current user has been issued a linkedincert generate HTML to display the details.
$issuehtml = '';
$linkedinbutton = '';
$issues = $DB->get_records('linkedincert_issues', array('userid' => $USER->id, 'linkedincertid' => $linkedincert->id));
if ($issues && !$canmanage) {
    // Get the most recent issue (there should only be one).
    $issue = reset($issues);
    $issuestring = get_string('receiveddate', 'linkedincert') . ': ' . userdate($issue->timecreated);
    $issuehtml = $OUTPUT->box($issuestring);

    $linkedinimg = '<img src="https://download.linkedin.com/desktop/add2profile/buttons/en_US.png " alt="LinkedIn Add to Profile button">';
    $linkedinbutton = '<div><a href="' . linkedincert_get_addtoprofile_link($linkedincert, $issue) . '">' . $linkedinimg . '</a></div>';
}


// Output all the page data.
echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($linkedincert->name));
echo $intro;
echo $issuehtml;
echo $linkedinbutton;
if (isset($reporttable)) {
    $numissues = \mod_linkedincert\certificate::get_number_of_issues($linkedincert->id, $cm, $groupmode);
    echo $OUTPUT->heading(get_string('listofissues', 'linkedincert', $numissues), 3);
    groups_print_activity_menu($cm, $pageurl);
    echo $reporttable->out($perpage, false);
}
echo $OUTPUT->footer($course);
