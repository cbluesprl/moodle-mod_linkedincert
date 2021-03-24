<?php
// This file is part of the Certificate module for Moodle - http://moodle.org/
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
 * Setting page for mod_linkedincert
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $url = $CFG->wwwroot . '/mod/linkedincert/verify_certificate.php';

    $settings->add(new admin_setting_configtext('linkedincert/organizationid',
        get_string('organizationid', 'linkedincert'), get_string('organizationid_help', 'linkedincert'), '', PARAM_INT));
    $settings->add(new admin_setting_configtext('linkedincert/organizationname',
        get_string('organizationname', 'linkedincert'), get_string('organizationname_help', 'linkedincert'), '', PARAM_TEXT));

    $settings->add(new \mod_linkedincert\admin_setting_link('linkedincert/verifycertificate',
        get_string('verifycertificate', 'linkedincert'), get_string('verifycertificatedesc', 'linkedincert'),
        get_string('verifycertificate', 'linkedincert'), new moodle_url('/mod/linkedincert/verify_certificate.php'), ''));
    $settings->add(new admin_setting_configcheckbox('linkedincert/verifyallcertificates',
        get_string('verifyallcertificates', 'linkedincert'),
        get_string('verifyallcertificates_desc', 'linkedincert', $url),
        0));

}