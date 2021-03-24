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
 * This file contains the backup tasks that provides all the settings and steps to perform a backup of the activity.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->dirroot . '/mod/linkedincert/backup/moodle2/backup_linkedincert_stepslib.php');

/**
 * Handles creating tasks to peform in order to create the backup.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_linkedincert_activity_task extends backup_activity_task {

    /**
     * Define particular settings this activity can have.
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define particular steps this activity can have.
     */
    protected function define_my_steps() {
        // The linkedincert only has one structure step.
        $this->add_step(new backup_linkedincert_activity_structure_step('linkedincert_structure', 'linkedincert.xml'));
    }

    /**
     * Code the transformations to perform in the activity in order to get transportable (encoded) links.
     *
     * @param string $content
     * @return mixed|string
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of linkedincerts.
        $search = "/(".$base."\/mod\/linkedincert\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@LINKEDINCERTINDEX*$2@$', $content);

        // Link to linkedincert view by moduleid.
        $search = "/(".$base."\/mod\/linkedincert\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@LINKEDINCERTVIEWBYID*$2@$', $content);

        return $content;
    }
}
