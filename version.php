<?php

/**
 * Code fragment to define the version of the linkedincert module
 *
 * @package mod_linkedincert
 * @category linkedincert
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

$plugin->version   = 2021031701; // The current module version (Date: YYYYMMDDXX).
$plugin->requires  = 2020061502; // Requires this Moodle version (3.9.2).
$plugin->cron      = 0; // Period for cron to check this module (secs).
$plugin->component = 'mod_linkedincert';

$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = "3.9.2"; // User-friendly version number.
