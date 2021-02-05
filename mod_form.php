<?php
/**
 * This script is owned by CBlue SPRL, please contact CBlue regarding any licences issues.
 *
 * @date :       13/10/2020
 * @author:      rlemaire@cblue.be
 * @copyright:   CBlue SPRL, 2020
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/htmlpack/locallib.php');
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

        $optionsheader = $mform->createElement('header', 'options', get_string('options', 'customcert'));


        $mform->addElement('selectyesno', 'verifyany', get_string('verifycertificateanyone', 'customcert'));
        $mform->addHelpButton('verifyany', 'verifycertificateanyone', 'customcert');
        $mform->setDefault('verifyany', get_config('customcert', 'verifyany'));
        $mform->setType('verifyany', PARAM_INT);

        $mform->addElement('text', 'requiredtime', get_string('coursetimereq', 'customcert'), array('size' => '3'));
        $mform->addHelpButton('requiredtime', 'coursetimereq', 'customcert');
        $mform->setDefault('requiredtime', get_config('customcert', 'requiredtime'));
        $mform->setType('requiredtime', PARAM_INT);

        $mform->insertElementBefore($optionsheader, 'verifyany');

        $this->standard_coursemodule_elements();

        $this->add_action_buttons(true, false, null);
    }


    public function data_preprocessing(&$defaultvalues)
    {
        global $COURSE;
        $draftitemid = file_get_submitted_draft_itemid('packagefile');
        file_prepare_draft_area($draftitemid, $this->context->id, 'mod_htmlpack', 'package', 0,
            array('subdirs' => 0, 'maxfiles' => 1));
        $defaultvalues['packagefile'] = $draftitemid;
    }
}