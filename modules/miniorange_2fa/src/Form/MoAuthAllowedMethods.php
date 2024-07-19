<?php
namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\MiniorangeCustomerProfile;

/**
 *  Showing Support form info.
 */
class MoAuthAllowedMethods extends FormBase
{
    public function getFormId()
    {
        return 'miniorange_2fa_allowed_methods';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $utilities = new MoAuthUtilities();

        $variables_and_values = array(
            'mo_auth_customer_admin_email',
            'mo_auth_2fa_license_type',
            'mo_auth_selected_2fa_methods',
        );

        $mo_db_values = $utilities->miniOrange_set_get_configurations($variables_and_values, 'GET');

        $license_type = $mo_db_values['mo_auth_2fa_license_type'] == '' ? 'DRUPAL_2FA_PLUGIN' : $mo_db_values['mo_auth_2fa_license_type'];
        $is_free = $license_type == 'DRUPAL_2FA_PLUGIN' || $license_type == 'PREMIUM' || $license_type == 'DRUPAL8_2FA_MODULE' ? FALSE : TRUE;

        $form['mo_Enable_allow_specific_2Fa']['markup_setup_allowed_2fa_note'] = array(
            '#markup' => t('<div class="">Select the 2FA methods allowed for the end users to configure.</div>'),
        );

        $mo_get_2fa_methods = $utilities::get_2fa_methods_for_inline_registration(FALSE);
        $selected_2fa_methods = isset($mo_db_values['mo_auth_selected_2fa_methods']) ? json_decode($mo_db_values['mo_auth_selected_2fa_methods'], true) : '';

        $mo_2fa_method_type  = $utilities::get2FAMethodType($mo_get_2fa_methods);
        $table_rows = $utilities::generateMethodeTypeRows($mo_2fa_method_type, $selected_2fa_methods, $form_state);

        $form['mo_Enable_allow_specific_2Fa']['mo_auth_2fa_methods_table'] = [
            '#type' => 'table',
            '#header' => [
                $this->t('TOTP METHODS'), $this->t('OTP METHODS'), $this->t('OTHER METHODS')],
        ];

        foreach ($table_rows as $rowNum => $rows ) {
            $form['mo_Enable_allow_specific_2Fa']['mo_auth_2fa_methods_table'][$rowNum] = $rows;
        }


        $form['actions'] = array('#type' => 'actions');
        $form['actions']['send'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#attributes' => [
                'class' => [
                    'use-ajax',
                    'button--primary'
                ],
            ],
            '#ajax' => [
                'callback' => [$this, 'submitModalFormAjax'],
                'event' => 'click',
            ],
            '#disabled' => $is_free,
        ];

        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        return $form;
    }

    public function submitModalFormAjax(array $form, FormStateInterface $form_state)
    {
        $response = new AjaxResponse();
        // If there are any form errors, AJAX replace the form.
        if ($form_state->hasAnyErrors()) {
            $response->addCommand(new ReplaceCommand('#modal_support_form', $form));
        } else {
            $utilities = new MoAuthUtilities();
            $variables_and_values = array(
                'mo_auth_selected_2fa_methods' => $utilities->getSelected2faMethods($form_state, 'mo_auth_2fa_methods_table'),
            );
            $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');
            \Drupal::messenger()->addStatus(t('Allowed 2FA methods saved successfully.'));

            if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
                global $base_url;
                $current_path = explode($base_url, $_SERVER['HTTP_REFERER']);
                $url_object = \Drupal::service('path.validator')->getUrlIfValid($current_path[1]);
                $route_name = $url_object->getRouteName();
                $response->addCommand(new RedirectCommand(Url::fromRoute($route_name)->toString()));
            } else {
                $response->addCommand(new RedirectCommand(Url::fromRoute('miniorange_2fa.customer_setup')->toString()));
            }
        }
        return $response;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }
}