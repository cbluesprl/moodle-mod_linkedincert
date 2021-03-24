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

require_once($CFG->dirroot . '/mod/linkedincert/backup/moodle2/restore_linkedincert_stepslib.php');

/**
 * The class definition for assigning tasks that provide the settings and steps to perform a restore of the activity.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_linkedincert_activity_task extends restore_activity_task {

    /**
     * Define  particular settings this activity can have.
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define particular steps this activity can have.
     */
    protected function define_my_steps() {
        // The linkedincert only has one structure step.
        $this->add_step(new restore_linkedincert_activity_structure_step('linkedincert_structure', 'linkedincert.xml'));
    }

    /**
     * Define the contents in the activity that must be processed by the link decoder.
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('linkedincert', array('intro'), 'linkedincert');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging to the activity to be executed by the link decoder.
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('LINKEDINCERTVIEWBYID', '/mod/linkedincert/view.php?id=$1', 'course_module');
        $rules[] = new restore_decode_rule('LINKEDINCERTINDEX', '/mod/linkedincert/view.php?id=$1', 'course');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied by the {@link restore_logs_processor} when restoring
     * linkedincert logs. It must return one array of {@link restore_log_rule} objects.
     *
     * @return array the restore log rules
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('linkedincert', 'add', 'view.php?id={course_module}', '{linkedincert}');
        $rules[] = new restore_log_rule('linkedincert', 'update', 'view.php?id={course_module}', '{linkedincert}');
        $rules[] = new restore_log_rule('linkedincert', 'view', 'view.php?id={course_module}', '{linkedincert}');
        $rules[] = new restore_log_rule('linkedincert', 'received', 'view.php?id={course_module}', '{linkedincert}');
        $rules[] = new restore_log_rule('linkedincert', 'view report', 'view.php?id={course_module}', '{linkedincert}');

        return $rules;
    }

}
