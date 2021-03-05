<?php

/**
 * Code fragment to define the version of the linkedincert module
 *
 * @package    mod_linkedincert
 * @copyright  2021 Renaud Lemaire <rlemaire@cblue.be>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */


defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

$plugin->version   = 2021020501; // The current module version (Date: YYYYMMDDXX).
$plugin->requires  = 2020061502; // Requires this Moodle version (3.9.2).
$plugin->cron      = 0; // Period for cron to check this module (secs).
$plugin->component = 'mod_linkedincert';
$plugin->dependencies = array(
    'mod_htmlpack' => 2020101900,
);

$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = "3.9.2"; // User-friendly version number.
