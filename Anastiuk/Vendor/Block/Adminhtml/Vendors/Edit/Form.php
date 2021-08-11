<?php

namespace Anastiuk\Vendor\Block\Adminhtml\Vendors\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    protected $_systemStore;

    protected $_approved;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\Data\FormFactory     $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config       $wysiwygConfig,
        \Anastiuk\Vendor\Model\Source\Approved  $approved,
        array                                   $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_approved = $approved;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(['data' => ['id' => 'edit_form', 'enctype' => 'multipart/form-data', 'action' => $this->getData('action'), 'method' => 'post']]);
        $form->setHtmlIdPrefix('md_cr_');
        if ($model) {
            $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Vendor Details'), 'class' => 'fieldset-wide']);
            $fieldset->addField('vendor_id', 'hidden', ['name' => 'vendor_id']);
        } else {
            $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Vendor Details'), 'class' => 'fieldset-wide']);
        }
        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'description',
            'text',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'logo',
            'image',
            [
                'name' => 'logo',
                'label' => __('Logo'),
                'title' => __('Logo'),
                'class' => 'logo_image',
                'renderer'  => '\Anastiuk\Vendor\Block\Adminhtml\Vendors\Grid\Renderer\Image',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'created_at',
            'date',
            [

                'name' => 'created_at',
                'title' => __('Create at'),
                'label' => __('Create at'),
                'maxlength' => '50',
                'required' => true,
                'date_format' => 'dd/MM/yyyy'
            ]
        );
        $form->setValues($model ? $model->getData() : '');
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
