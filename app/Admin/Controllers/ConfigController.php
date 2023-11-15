<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Config;

class ConfigController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Config';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Config());

        $grid->column('id', __('Id'));
        $grid->column('notification', __('Notification'));
        $grid->column('trigger', __('Trigger'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Config::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('notification', __('Notification'));
        $show->field('trigger', __('Trigger'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Config());

        $form->textarea('notification', __('Notification'));
        $form->select('trigger', __('Trigger'))
            ->options([
                'open_app' => 'Open App',
                'before_getting_servers_list' => 'Before Getting Servers List',
                'after_getting_servers_list' => 'After Getting Servers List',
                'before_connect_to_server' => 'Before Connect To Server',
                'after_connect_to_server' => 'After Connect To Server',
                'before_disconnect_srom_server' => 'Before Disconnect Srom Server',
                'after_disconnect_from_server' => 'After Disconnect From Server',
                'before_close_app' => 'Before Close App',
            ]

            )
            ->default('before_getting_servers_list');


        return $form;
    }

    public function getNotification( $trigger )
    {
        try {
            // Fetch data from the 'configs' table based on the provided trigger
            $config = Config::select("notification")->where('trigger', $trigger)->first();

            if (!$config) {
                return response()->json(['message' => 'Config not found'], 404);
            }

            // Return the config data as JSON
            return response()->json($config, 200);
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
