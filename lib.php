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
 * linkedincert module core interaction API
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

/**
 * Add linkedincert instance.
 *
 * @param stdClass $data
 * @param mod_linkedincert_mod_form $mform
 * @return int new linkedincert instance id
 */
function linkedincert_add_instance($data, $mform) {
    global $DB;

    $data->timecreated = time();
    $data->timemodified = $data->timecreated;
    $data->id = $DB->insert_record('linkedincert', $data);

    return $data->id;
}

/**
 * Update linkedincert instance.
 *
 * @param stdClass $data
 * @param mod_linkedincert_mod_form $mform
 * @return bool true
 */
function linkedincert_update_instance($data, $mform) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;

    return $DB->update_record('linkedincert', $data);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id
 * @return bool true if successful
 */
function linkedincert_delete_instance($id) {
    global $CFG, $DB;

    // Ensure the linkedincert exists.
    if (!$linkedincert = $DB->get_record('linkedincert', array('id' => $id))) {
        return false;
    }

    // Get the course module as it is used when deleting files.
    if (!$cm = get_coursemodule_from_instance('linkedincert', $id)) {
        return false;
    }

    // Delete the linkedincert instance.
    if (!$DB->delete_records('linkedincert', array('id' => $id))) {
        return false;
    }

    // Delete any files associated with the linkedincert.
    $context = context_module::instance($cm->id);
    $fs = get_file_storage();
    $fs->delete_area_files($context->id);

    return true;
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * This function will remove all posts from the specified linkedincert
 * and clean up any related data.
 *
 * @param stdClass $data the data submitted from the reset course.
 * @return array status array
 */
function linkedincert_reset_userdata($data) {
    global $DB;

    $componentstr = get_string('modulenameplural', 'linkedincert');
    $status = array();

    if (!empty($data->reset_linkedincert)) {
        $sql = "SELECT cert.id
                  FROM {linkedincert} cert
                 WHERE cert.course = :courseid";
        $DB->delete_records_select('linkedincert_issues', "linkedincertid IN ($sql)", array('courseid' => $data->courseid));
        $status[] = array('component' => $componentstr, 'item' => get_string('deleteissuedcertificates', 'linkedincert'),
            'error' => false);
    }

    return $status;
}

/**
 * The features this activity supports.
 *
 * @uses FEATURE_GROUPS
 * @uses FEATURE_GROUPINGS
 * @uses FEATURE_GROUPMEMBERSONLY
 * @uses FEATURE_MOD_INTRO
 * @uses FEATURE_COMPLETION_TRACKS_VIEWS
 * @uses FEATURE_GRADE_HAS_GRADE
 * @uses FEATURE_GRADE_OUTCOMES
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function linkedincert_supports($feature) {
    switch ($feature) {
        case FEATURE_GROUPS:
            return true;
        case FEATURE_GROUPINGS:
            return true;
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}

function linkedincert_get_addtoprofile_link($linkedincert, $issue) {
    $config = get_config('linkedincert');

    $dateTimeCreated = new DateTime();
    $dateTimeCreated->setTimestamp($issue->timecreated);

    $params = [
        'startTask' => 'CERTIFICATION_NAME',
        'name' => $linkedincert->name,
        'issueYear' => $dateTimeCreated->format('Y'),
        'issueMonth' => $dateTimeCreated->format('m'),
        'certUrl' => (string) (new moodle_url('/mod/linkedincert/verify_certificate.php', ['code' => $issue->code])),
        'certId' => $issue->code,
    ];
    if (!empty($config->organizationid)) {
        $params['organizationId'] = $config->organizationid;
    }
    else {
        $params['organizationName'] = $config->organizationname;
    }

    return  'https://www.linkedin.com/profile/add?' . http_build_query($params);
}