<?php
/**
 * @package mod_linkedincert
 * @category linkedincert
 * @date 13/10/2020
 * @author Renaud Lemaire <rlemaire@cblue.be>
 * @copyright 2020 CBlue SPRL {@link https://www.cblue.be}
 * @copyright based on work by 2013 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->libdir.'/filelib.php');

class mod_linkedincert_mod_form extends moodleform_mod
{
    function definition()
    {
        global $CFG, $DB;
        $mform =& $this->_form;


        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size'=>'48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $this->standard_intro_elements();

        $optionsheader = $mform->createElement('header', 'options', get_string('options', 'linkedincert'));


        $mform->addElement('selectyesno', 'verifyany', get_string('verifycertificateanyone', 'linkedincert'));
        $mform->addHelpButton('verifyany', 'verifycertificateanyone', 'linkedincert');
        $mform->setDefault('verifyany', get_config('linkedincert', 'verifyany'));
        $mform->setType('verifyany', PARAM_INT);

        $mform->addElement('text', 'requiredtime', get_string('coursetimereq', 'linkedincert'), array('size' => '3'));
        $mform->addHelpButton('requiredtime', 'coursetimereq', 'linkedincert');
        $mform->setDefault('requiredtime', get_config('linkedincert', 'requiredtime'));
        $mform->setType('requiredtime', PARAM_INT);

        $mform->insertElementBefore($optionsheader, 'verifyany');

        $this->standard_coursemodule_elements();

        $this->add_action_buttons(true, false, null);
    }


    public function data_preprocessing(&$defaultvalues)
    {
        global $COURSE;
        $draftitemid = file_get_submitted_draft_itemid('packagefile');
        file_prepare_draft_area($draftitemid, $this->context->id, 'mod_linkedincert', 'package', 0,
            array('subdirs' => 0, 'maxfiles' => 1));
        $defaultvalues['packagefile'] = $draftitemid;
    }
}