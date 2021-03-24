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
 * Define all the backup steps that will be used by the backup_linkedincert_activity_task.
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
 * Define the complete linkedincert structure for backup, with file and id annotations.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_linkedincert_activity_structure_step extends backup_activity_structure_step {

    /**
     * Define the structure of the backup file.
     *
     * @return backup_nested_element
     */
    protected function define_structure() {

        // The instance.
        $linkedincert = new backup_nested_element('linkedincert', array('id'), array(
            'name', 'intro', 'introformat', 'requiredtime', 'verifyany', 'timecreated', 'timemodified'));

        // The issues.
        $issues = new backup_nested_element('issues');
        $issue = new backup_nested_element('issue', array('id'), array(
            'linkedincertid', 'userid', 'timecreated', 'code'));

        // Build the tree.
        $linkedincert->add_child($issues);
        $issues->add_child($issue);

        // Define sources.
        $linkedincert->set_source_table('linkedincert', array('id' => backup::VAR_ACTIVITYID));

        // If we are including user info then save the issues.
        if ($this->get_setting_value('userinfo')) {
            $issue->set_source_table('linkedincert_issues', array('linkedincertid' => backup::VAR_ACTIVITYID));
        }

        // Annotate the user id's where required.
        $issue->annotate_ids('user', 'userid');

        // Define file annotations.
        $linkedincert->annotate_files('mod_linkedincert', 'intro', null);
        $linkedincert->annotate_files('mod_linkedincert', 'image', null, context_course::instance($this->get_courseid())->id);

        // Return the root element (linkedincert), wrapped into standard activity structure.
        return $this->prepare_activity_structure($linkedincert);
    }
}
