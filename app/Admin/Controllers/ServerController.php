<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Server;

class ServerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Server';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Server());

        $grid->column('id', __('Id'));
        $grid->column('host_name', __('Host name'));
        $grid->column('ip', __('Ip'));
        $grid->column('score', __('Score'));
        $grid->column('ping', __('Ping'));
        $grid->column('speed', __('Speed'));
        $grid->column('country_long', __('Country long'));
        $grid->column('country_short', __('Country short'));
        $grid->column('num_vpn_sessions', __('Num vpn sessions'));
        $grid->column('uptime', __('Uptime'));
        $grid->column('total_users', __('Total users'));
        $grid->column('total_traffic', __('Total traffic'));
        $grid->column('log_type', __('Log type'));
        $grid->column('operator', __('Operator'));
        $grid->column('message', __('Message'));
        $grid->column('openvpn_config_data_base64', __('Openvpn config data base64'));
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
        $show = new Show(Server::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('host_name', __('Host name'));
        $show->field('ip', __('Ip'));
        $show->field('score', __('Score'));
        $show->field('ping', __('Ping'));
        $show->field('speed', __('Speed'));
        $show->field('country_long', __('Country long'));
        $show->field('country_short', __('Country short'));
        $show->field('num_vpn_sessions', __('Num vpn sessions'));
        $show->field('uptime', __('Uptime'));
        $show->field('total_users', __('Total users'));
        $show->field('total_traffic', __('Total traffic'));
        $show->field('log_type', __('Log type'));
        $show->field('operator', __('Operator'));
        $show->field('message', __('Message'));
        $show->field('openvpn_config_data_base64', __('Openvpn config data base64'));
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
        $form = new Form(new Server());

        $form->text('host_name', __('Host name'));
        $form->ip('ip', __('Ip'));
        $form->number('score', __('Score'));
        $form->number('ping', __('Ping'));
        $form->number('speed', __('Speed'));
        $form->text('country_long', __('Country long'));
        $form->text('country_short', __('Country short'));
        $form->number('num_vpn_sessions', __('Num vpn sessions'));
        $form->number('uptime', __('Uptime'));
        $form->number('total_users', __('Total users'));
        $form->number('total_traffic', __('Total traffic'));
        $form->text('log_type', __('Log type'));
        $form->text('operator', __('Operator'));
        $form->text('message', __('Message'));
        $form->textarea('openvpn_config_data_base64', __('Openvpn config data base64'));

        return $form;
    }

    public function list()
    {
        $servers = Server::all();
        $serverDataString = "*vpn_servers";
        $serverDataString .= "\x0D\x0A";
        $serverDataString .= "#HostName,IP,Score,Ping,Speed,CountryLong,CountryShort,NumVpnSessions,Uptime,TotalUsers,TotalTraffic,LogType,Operator,Message,OpenVPN_ConfigData_Base64";
        $serverDataString .= "\x0D\x0A";

        foreach($servers as $server) {
            //$serverDataString .= $server->id . ',';
            $serverDataString .= $server->host_name . ',';
            $serverDataString .= $server->ip . ',';
            $serverDataString .= $server->score . ',';
            $serverDataString .= $server->ping . ',';
            $serverDataString .= $server->speed . ',';
            $serverDataString .= $server->country_long . ',';
            $serverDataString .= $server->country_short . ',';
            $serverDataString .= $server->num_vpn_sessions . ',';
            $serverDataString .= $server->uptime . ',';
            $serverDataString .= $server->total_users . ',';
            $serverDataString .= $server->total_traffic . ',';
            $serverDataString .= $server->log_type . ',';
            $serverDataString .= $server->operator . ',';
            $serverDataString .= $server->message . ',';
            $serverDataString .= $server->openvpn_config_data_base64;
            $serverDataString .= "\x0D\x0A";
        }

        // Return the list of servers as JSON response
        return response($serverDataString)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
