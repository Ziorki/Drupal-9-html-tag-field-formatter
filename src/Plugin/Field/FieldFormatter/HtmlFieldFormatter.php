<?php

namespace Drupal\field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'html_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "html_field_formatter",
 *   label = @Translation("Html field formatter"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class HtmlFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $options = parent::defaultSettings();

    $options['html_tag'] = 'span';
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    $form['html_tag'] = [
      '#title' => 'Select HTML Tag',
      '#type' => 'select',
      '#options' => [
        'h1' => $this->t('Header 1'),
        'h2' => $this->t('Header 2'),
        'h3' => $this->t('Header 3'),
        'h4' => $this->t('Header 4'),
        'h5' => $this->t('Header 5'),
        'h6' => $this->t('Header 6'),
        'div' => $this->t('Divider'),
        'span' => $this->t('Spanner'),
        'p' => $this->t('Paragraph'),
        'header' => $this->t('Header'),
        'footer' => $this->t('Footer'),
        'article' => $this->t('Article'),
        'section' => $this->t('Section'),
      ],
      '#default_value' => $this->getSetting('html_tag'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    $tag = $this->getSetting('html_tag');

    $escaped = nl2br(Html::escape($item->value));
    $content = '<' . $tag . '>' . $escaped . '</' . $tag . '>';

    return $content;
  }

}
