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
 * Define all the restore steps that will be used by the restore_linkedincert_activity_task.
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
 * Define the complete linkedincert structure for restore, with file and id annotations.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_linkedincert_activity_structure_step extends restore_activity_structure_step {

    /**
     * Define the different items to restore.
     *
     * @return array the restore paths
     */
    protected function define_structure() {
        // The array used to store the path to the items we want to restore.
        $paths = array();

        // The linkedincert instance.
        $paths[] = new restore_path_element('linkedincert', '/activity/linkedincert');

        // Check if we want the issues as well.
        if ($this->get_setting_value('userinfo')) {
            $paths[] = new restore_path_element('linkedincert_issue', '/activity/linkedincert/issues/issue');
        }

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Handles restoring the linkedincert activity.
     *
     * @param stdClass $data the linkedincert data
     */
    protected function process_linkedincert($data) {
        global $DB;

        $data = (object) $data;
        $data->course = $this->get_courseid();
        $data->timecreated = $this->apply_date_offset($data->timecreated);
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // Insert the linkedincert record.
        $newitemid = $DB->insert_record('linkedincert', $data);

        // Immediately after inserting record call this.
        $this->apply_activity_instance($newitemid);
    }

    /**
     * Handles restoring a linkedincert issue.
     *
     * @param stdClass $data the linkedincert data
     */
    protected function process_linkedincert_issue($data) {
        global $DB;

        $data = (object) $data;
        $oldid = $data->id;

        $data->linkedincertid = $this->get_new_parentid('linkedincert');
        $data->timecreated = $this->apply_date_offset($data->timecreated);

        $newitemid = $DB->insert_record('linkedincert_issues', $data);
        $this->set_mapping('linkedincert_issue', $oldid, $newitemid);
    }

    /**
     * Called immediately after all the other restore functions.
     */
    protected function after_execute() {
        parent::after_execute();

        // Add the files.
        $this->add_related_files('mod_linkedincert', 'intro', null);

        // Note - we can't use get_old_contextid() as it refers to the module context.
        $this->add_related_files('mod_linkedincert', 'image', null, $this->get_task()->get_info()->original_course_contextid);
    }
}
