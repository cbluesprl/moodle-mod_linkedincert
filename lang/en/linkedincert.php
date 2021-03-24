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
 * Language strings for the linkedincert module.
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'LinkedIn certificates';
$string['pluginadministration'] = 'LinkedIn certificates administration';

$string['modulename'] = 'LinkedIn certificates Activity';
$string['modulename_link'] = 'mod/linkedincert/view';
$string['modulenameplural'] = 'LinkedIn certificates Activities';

$string['awardedto'] = 'Awarded to';
$string['cannotverifyallcertificates'] = 'You do not have the permission to verify all certificates on the site.';
$string['certificate'] = 'Certificate';
$string['code'] = 'Code';
$string['coursetimereq_help'] = 'Enter here the minimum amount of time, in minutes, that a student must be logged into the course before they will be able to receive
the certificate.';
$string['coursetimereq'] = 'Required minutes in course';
$string['deleteconfirm'] = 'Delete confirmation';
$string['deleteissueconfirm'] = 'Are you sure you want to delete this certificate issue?';
$string['deleteissuedcertificates'] = 'Delete issued certificates';
$string['invalidcode'] = 'Invalid code supplied.';
$string['linkedincertsettings'] = 'LinkedIn Certificates Settings';
$string['listofissues'] = 'Recipients: {$a}';
$string['nocerts'] = 'There are no certificates for this course';
$string['notissued'] = 'Not awarded';
$string['notverified'] = 'Not verified';
$string['options'] = 'Options';
$string['organizationid_help'] = 'Linkedin ID of your organization<br /><div style="margin-bottom:15px; padding: 0 15px; border:1px solid #dee2e6 !important"><h3>How to find your LinkedIn Organization ID?</h3><ol><li>Log in to LinkedIn as the admin for your business\' Organisation Page</li><li>Check the URL used when you are logged in as the admin</li><li>Your LinkedIn Organization ID is the seven-digit number in the URL :<br/><i>https://www.linkedin.com/company/ORGANIZATION_ID/admin/</i></li></ol></div>';
$string['organizationid'] = 'Organization id';
$string['organizationname_help'] = 'If you do not have an Organization id, this field will be used instead';
$string['organizationname'] = 'Organization name';
$string['privacy:metadata:linkedincert_issues'] = 'The list of issued certificates';
$string['privacy:metadata:linkedincert_issues:code'] = 'The code that belongs to the certificate';
$string['privacy:metadata:linkedincert_issues:linkedincertid'] = 'The ID of the certificate';
$string['privacy:metadata:linkedincert_issues:timecreated'] = 'The time the certificate was issued';
$string['privacy:metadata:linkedincert_issues:userid'] = 'The ID of the user who was issued the certificate';
$string['receiveddate'] = 'Awarded on';
$string['requiredtimenotmet'] = 'You must spend at least a minimum of {$a->requiredtime} minutes in the course before you can access this certificate.';
$string['verified'] = 'Verified';
$string['verify'] = 'Verify';
$string['verifyallcertificates_desc'] = 'When this setting is enabled any person (including users not logged in) can visit the link \'{$a}\' in order to verify any certificate on the site, rather than having to go to the verification link for each certificate.
Note - this only applies to certificates where \'Allow anyone to verify a certificate\' has been set to \'Yes\' in the certificate settings.';
$string['verifyallcertificates'] = 'Allow verification of all certificates';
$string['verifycertificate'] = 'Verify certificate';
$string['verifycertificateanyone_help'] = 'This setting enables anyone with the certificate verification link (including users not logged in) to verify a certificate.';
$string['verifycertificateanyone'] = 'Allow anyone to verify a certificate';
$string['verifycertificatedesc'] = 'This link will take you to a new screen where you will be able to verify certificates on the site';
