<?php

namespace Drupal\faq_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 * @Block(
 *  id = "faq_block",
 *  admin_label = @Translation("FAQ Block"),
 * )
 */
class FaqBlock extends BlockBase {

  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'faq_items' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $items = [];

    $items = $config['faq_items'];

    $form['#tree'] = TRUE;

    $form['section_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('FAQ Section Title '),
      '#default_value' => $config['section_title']??'',
    ];

    $form['section_description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('FAQ Section Description '),
      '#default_value' => $config['section_description']??'',
    ];

    $form['items_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('FAQ Items Section'),
      '#prefix' => '<div id="items-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    if (!$form_state->has('num_faq_items')) {
      $form_state->set('num_faq_items', count($config['faq_items']));
    }

    $count_faq_items = $form_state->get('num_faq_items');
    for ($i = 0; $i < $count_faq_items; $i++) {
      $items = array_values($items);
      $form['items_fieldset']['items'][$i] = [
        '#type' => 'faq_fields',
        '#title' => t('Item'),
        '#description' => t('Use autocomplete to find it'),
        '#selection_handler' => 'default',
        '#default_value' => $items[$i]??'',
        '#draggable' => TRUE,

      ];
    }

    $form['toggle_icon_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Toggle Icon Color'),
      '#default_value' => $config['toggle_icon_color']??'',
      '#description' => t('Plug and minus icon color.'),
    ];

    $form['items_fieldset']['actions'] = [
      '#type' => 'actions',
    ];

    $form['items_fieldset']['actions']['add_faq_item'] = [
      '#type' => 'submit',
      '#value' => t('Add FAQ Item'),
      '#submit' => [[$this, 'addOne']],
      '#ajax' => [
        'callback' => [$this, 'addFaqItemCallback'],
        'wrapper' => 'items-fieldset-wrapper',
      ],
      '#attributes' => array(
        'class' => array('button--primary')
      )
    ];

    if ($count_faq_items > 1) {
      $form['items_fieldset']['actions']['remove_faq_item'] = [
        '#type' => 'submit',
        '#value' => t('Remove FAQ Item'),
        '#submit' => [[$this, 'removeFaqCallback']],
        '#ajax' => [
          'callback' => [$this, 'addFaqItemCallback'],
          'wrapper' => 'items-fieldset-wrapper',
        ]
      ];
    }

    return $form;
  }
  /**
   * Add item callback
   * @param array              &$form
   * @param FormStateInterface $form_state
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $count_faq_items = $form_state->get('num_faq_items');
    $add_button = $count_faq_items + 1;
    $form_state->set('num_faq_items', $add_button);
    $form_state->setRebuild();
  }

    /**
     * Add faq item callback
     * @param array              &$form
     * @param FormStateInterface $form_state
     */
    public function addFaqItemCallback(array &$form, FormStateInterface $form_state) {
      return $form['settings']['items_fieldset'];
    }

    /**
     * Remove faq item callback
     * @param  array              &$form
     * @param  FormStateInterface $form_state
     * @return [type]
     */
    public function removeFaqCallback(array &$form, FormStateInterface $form_state) {
      $count_faq_items = $form_state->get('num_faq_items');
      if ($count_faq_items > 1) {
        $remove_button = $count_faq_items - 1;
        $form_state->set('num_faq_items', $remove_button);
      }
      $form_state->setRebuild();
    }

    /**
     * Block configuration submit
     * @param  [type]             $form
     * @param  FormStateInterface $form_state
     * @return [type]
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
      foreach ($form_state->getValues() as $key => $value) {
        if ($key === 'items_fieldset') {
          if (isset($value['items'])) {
            $items = $value['items'];

            foreach ($items as $key => $item) {
              if ($item['question'] === '' || !$item) {
                unset($items[$key]);
              } else {
                if(isset($item['answer']['value']) && $item['answer']['value'] != '') {
                  $this->custom_editor_record_file_usage($item['answer']['value']);
                }
              }
            }
            $this->configuration['faq_items'] = $items;
          }
        }

        if ($form_state->getValue('section_title') != null) {
          $this->configuration['section_title'] = $form_state->getValue('section_title');
        }

        if ($form_state->getValue('section_description') != null) {
          $this->configuration['section_description'] = $form_state->getValue('section_description');
        }

        if ($form_state->getValue('toggle_icon_color') != null) {
          $this->configuration['toggle_icon_color'] = $form_state->getValue('toggle_icon_color');
        }
      }
    }

    /**
     * @param $content
     * @throws \Drupal\Core\Entity\EntityStorageException
     */
    function custom_editor_record_file_usage($content) {
      $uuids = _editor_parse_file_uuids($content);
      if(!empty($uuids)) {
        foreach ($uuids as $uuid) {
          if ($file = \Drupal::service('entity.repository')->loadEntityByUuid('file', $uuid)) {
            /** @var \Drupal\file\FileInterface $file */
            if ($file->isTemporary()) {
              $file->setPermanent();
              $file->save();
            }
            \Drupal::service('file.usage')->add($file, 'editor', 'file', $file->fid->value);
          }
        }
      }
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
      $faq_items = array();
      $faqs_data = array();
      if (isset($this->configuration['faq_items'])) {
        if (count($this->configuration['faq_items']) > 0) {
          $faq_items = $this->configuration['faq_items'];
        }
      }
      if (isset($this->configuration['section_title'])) {
        $faqs_data['section_title'] = $this->configuration['section_title'];
      }
      if (isset($this->configuration['section_description'])) {
        $faqs_data['section_description'] = $this->configuration['section_description'];
      }
      if (isset($this->configuration['toggle_icon_color'])) {
        $faqs_data['color'] = $this->configuration['toggle_icon_color'];
      }

      return array(
        '#theme' => 'faq_block',
        '#faqs' => $faq_items,
        '#faqs_data' => $faqs_data,
        '#attached' => array(
          'library' => array(
            'faq_block/faq_libraries',
          ),
          'drupalSettings' => array(
            'config_data' => array()
          ),
        ),
      );
    }
  }