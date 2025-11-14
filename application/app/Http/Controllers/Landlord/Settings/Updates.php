<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for template
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\Landlord\Settings;

use App\Http\Controllers\Controller;
use App\Http\Responses\Landlord\Settings\Updates\CheckResponse;
use App\Http\Responses\Landlord\Settings\Updates\ShowResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;

class Updates extends Controller {

    public function __construct(
    ) {

        //parent
        parent::__construct();

        //authenticated
        $this->middleware('auth');

    }
    /**
     * Display the dashboard home page
     * @return blade view | ajax view
     */
    public function show() {

        //get settings
        $settings = \App\Models\Landlord\Settings::Where('settings_id', 'default')->first();

        //reponse payload
        $payload = [
            'page' => $this->pageSettings('index'),
            'settings' => $settings,
            'section' => 'general',
        ];

        //show the form
        return new ShowResponse($payload);
    }

    /**
     * Display general settings
     *
     * @return \Illuminate\Http\Response
     */
    public function checkUpdates() {

        //crumbs, page data & stats
        $page = $this->pageSettings();

        // DESHABILITADO: Comunicación con servidor de actualizaciones remoto
        // Ya no se envían datos a growcrm.io ni se verifican actualizaciones remotas
        // Retornar mensaje informativo de que las actualizaciones están deshabilitadas
        
        return new CheckResponse([
            'type' => 'failed-message',
            'message_heading' => 'Actualizaciones Deshabilitadas',
            'message' => 'La verificación de actualizaciones remotas ha sido deshabilitada. No se enviarán datos a servidores externos. Si necesitas actualizar el sistema, hazlo manualmente descargando las actualizaciones desde tu fuente de distribución.',
        ]);
    }

    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.settings'),
                __('lang.updates'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'meta_title' => __('lang.settings'),
            'heading' => __('lang.settings'),
            'page' => 'landlord-settings',
            'mainmenu_updates' => 'active',
            'inner_menu_updates' => 'active',
        ];

        //show
        config(['visibility.left_inner_menu' => 'settings']);

        //return
        return $page;
    }
}