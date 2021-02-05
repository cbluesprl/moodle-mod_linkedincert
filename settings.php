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
 * @package    mod_linkedincert
 * @copyright  2021 Renaud Lemaire <rlemaire@cblue.be>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */

defined('MOODLE_INTERNAL') || die;

$url = $CFG->wwwroot . '/mod/customcert/verify_certificate.php';

$ADMIN->add('modsettings', new admin_category('linkedincert', get_string('pluginname', 'mod_linkedincert')));
$settings = new admin_settingpage('modsettinglinkedincert', new lang_string('linkedincertsettings', 'mod_linkedincert'));

$settings->add(new admin_setting_configtext('linkedincert/organizationid',
    get_string('organizationid', 'linkedincert'), get_string('organizationid_help', 'linkedincert'), '', PARAM_INT));
$settings->add(new admin_setting_configtext('linkedincert/organizationname',
    get_string('organizationname', 'linkedincert'), get_string('organizationname_help', 'linkedincert'), '', PARAM_TEXT));

$settings->add(new \mod_customcert\admin_setting_link('customcert/verifycertificate',
    get_string('verifycertificate', 'customcert'), get_string('verifycertificatedesc', 'customcert'),
    get_string('verifycertificate', 'customcert'), new moodle_url('/mod/customcert/verify_certificate.php'), ''));
$settings->add(new admin_setting_configcheckbox('customcert/verifyallcertificates',
    get_string('verifyallcertificates', 'customcert'),
    get_string('verifyallcertificates_desc', 'customcert', $url),
    0));

$ADMIN->add('linkedincert', $settings);

// Element plugin settings.
$ADMIN->add('linkedincert', new admin_category('linkedincertelements', get_string('pluginname', 'linkedincert')));
$plugins = \core_plugin_manager::instance()->get_plugins_of_type('linkedincertelement');
foreach ($plugins as $plugin) {
    $plugin->load_settings($ADMIN, 'linkedincertelements', $hassiteconfig);
}


// Tell core we already added the settings structure.
$settings = null;
