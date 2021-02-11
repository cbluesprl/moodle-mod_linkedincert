<?php
// This file is part of the customcert module for Moodle - http://moodle.org/
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
 * Language strings for the linkedincert module.
 *
 * @package    mod_linkedincert
 * @copyright  2021 Renaud Lemaire <rlemaire@cblue.be>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */

$string['pluginname'] = 'LinkedIn certificates';
$string['pluginadministration'] = 'LinkedIn certificates administration';

$string['modulename'] = 'LinkedIn certificates Activity';
$string['modulename_link'] = 'mod/linkedincert/view';
$string['modulenameplural'] = 'LinkedIn certificates Activities';

$string['linkedincertsettings'] = 'LinkedIn Certificates Settings';
$string['organizationid'] = 'Organization id';
$string['organizationid_help'] = 'Linkedin ID of your organization';
$string['organizationname'] = 'Organization name';
$string['organizationname_help'] = 'If you do not have an Organization id, this field will be used instead';


$string['receiveddate'] = 'Awarded on';
$string['listofissues'] = 'Recipients: {$a}';


$string['awardedto'] = 'Awarded to';
$string['cannotverifyallcertificates'] = 'You do not have the permission to verify all certificates on the site.';
$string['certificate'] = 'Certificate';
$string['code'] = 'Code';
$string['verified'] = 'Verified';
$string['verify'] = 'Verify';
$string['verifyallcertificates'] = 'Allow verification of all certificates';
$string['verifyallcertificates_desc'] = 'When this setting is enabled any person (including users not logged in) can visit the link \'{$a}\' in order to verify any certificate on the site, rather than having to go to the verification link for each certificate.

Note - this only applies to certificates where \'Allow anyone to verify a certificate\' has been set to \'Yes\' in the certificate settings.';
$string['verifycertificate'] = 'Verify certificate';
$string['verifycertificatedesc'] = 'This link will take you to a new screen where you will be able to verify certificates on the site';
$string['verifycertificateanyone'] = 'Allow anyone to verify a certificate';
$string['verifycertificateanyone_help'] = 'This setting enables anyone with the certificate verification link (including users not logged in) to verify a certificate.';