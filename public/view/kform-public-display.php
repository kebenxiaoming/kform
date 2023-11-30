<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       none
 * @since      1.0.0
 *
 * @package    kform
 * @subpackage kebenxiaoming <kebenxiaoming@gmail.com>
 */
?>
<form id="kform_form">
    <div class="kform-alert alert alert-danger" id="danger-alert" role="alert">

    </div>
    <div class="kform-alert alert alert-success" id="success-alert" role="alert">

    </div>
    <div class="form-group">
        <label for="input-title"><?php echo __kform_lang("Title");?></label>
        <input type="text" class="form-control" maxlength="200" id="input-title">
    </div>
    <div class="form-group">
        <label for="input-email"><?php echo __kform_lang("Email");?></label>
        <input type="email" class="form-control" maxlength="100" id="input-email">
    </div>
    <div class="form-group">
        <label for="input-phone"><?php echo __kform_lang("Phone",'kform');?></label>
        <input type="text" class="form-control" maxlength="100" id="input-phone">
    </div>
    <div class="form-group">
        <label for="input-content"><?php echo __kform_lang("Content");?></label>
        <textarea class="form-control" id="input-content" maxlength="500"></textarea>
    </div>
    <span type="submit" data-click="1" id="kform_form_btn" class="btn btn-primary disabled"><?php echo __kform_lang("Submit");?></span>
</form>