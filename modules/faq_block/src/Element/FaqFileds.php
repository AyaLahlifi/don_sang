<?php

namespace Drupal\faq_block\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;

/**
 * Provides a faq form element.
 *
 * Usage example:
 * @code
 * $form['faq'] = [
 *   '#type' => 'faq_fields',
 *   '#default_value' => '',
 * ];
 * @endcode
 *
 * @FormElement("faq_fields")
 */
class FaqFileds extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#multiple' => FALSE,
      '#default_value' => NULL,
      '#process' => [
        [$class, 'processFaqFileds'],
        [$class, 'processGroup'],
      ],
      '#theme_wrappers' => ['container'],
    ];
  }

  /**
   * Processes the faq_fields form element.
   *
   * @param array $element
   *   The form element to process.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param array $complete_form
   *   The complete form structure.
   *
   * @return array
   *   The processed element.
   *
   */
  public static function processFaqFileds(array &$element, FormStateInterface $form_state, array &$complete_form) {

    $element['question'] = [
      '#type' => 'textfield',
      '#title' => t('FAQ  Title'),
      '#default_value' => $element['#default_value']['question'],
      '#description' => t('Enter the FAQ heading. We can also enter the HTML tags on this field.<br><small><em>Set the title field empty or blank to delete the current FAQ item</em></small>'),
      '#prefix' => '<div class="panel"><div class="panel__content">',
      '#size' => '100'
    ];
    $element['answer'] = [
      '#id' => 'answer',
      '#type' => 'text_format',
      '#title' => t('FAQ Description'),
      '#default_value' => ($element['#default_value']['answer'])?$element['#default_value']['answer']['value']:'',
      '#format' => (isset($element['#default_value']['answer']['format']))?$element['#default_value']['answer']['format']:'basic_html',
      '#size' => 60,
      '#rows' => 30,
      '#suffix' => '</div></div>',
      '#description' => t('Enter the FAQ description'),
    ];
    return $element;

  }
}
