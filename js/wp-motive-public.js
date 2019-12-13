/**
 * Main Script for the Public Area
 * @since 02-Dic-2019
 * @version 1.0.0
 * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
(function($) {
    'use strict';
    $(document).ready(function (){
        var endPoint                     = 'https://miusage.com/v1/challenge/1/';
        var optionsForm                  = $('.wp-motive-form');
        var wpMotiveTableBody            = $('.wp-motive-table-data tbody');
        var bodyContent                  = '';
        var wp_motive_data_loaded_status = optionsForm.find('input[name="wp_motive_data_loaded_status"]').val();
        var wp_motive_users_data_override= optionsForm.find('input[name="wp_motive_users_data_override"]').val();
        var usersData                    = [];

        if( wp_motive_data_loaded_status === "no" ){
            $.when( endPointRequest( endPoint, wpMotiveTableBody ) ).done( function ( result ) {

                if ( result !== undefined ) {
                    for( var key in result.data.rows ) {
                        if( result.data.rows.hasOwnProperty( key ) ){
                            var unixTimeStamp = result.data.rows[key].date;
                            var userDate      = readableDate(unixTimeStamp);
                            var id            = result.data.rows[key].id;
                            var fname         = result.data.rows[key].fname;
                            var lname         = result.data.rows[key].lname;
                            var email         = result.data.rows[key].email;
                            var user          = {};

                            bodyContent += '<tr>';
                            bodyContent += '<td>'+ result.data.rows[key].id +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].fname +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].lname +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].email +'</td>';
                            bodyContent += '<td>'+ userDate +'</td>';
                            bodyContent += '</tr>';
                            // We need to persist the information until the next reload.
                            user.id    = id;
                            user.fname = fname;
                            user.lname = lname;
                            user.email = email;
                            user.date  = userDate;
                            // Add it to the array
                            usersData.push(user);
                        }
                    }
                    wpMotiveTableBody.html( bodyContent );
                    // Update Plugin Option
                    updatePluginOption( optionsForm, 'wp_motive_data_loaded_status', 'yes' );
                    cacheEndpointData( optionsForm, usersData );
                    updateLoadedTableTime( optionsForm );
                    $('.wp-motive-notification').text( wp_motive.message_endpoint_loaded );
                    bodyContent = ''; // Housekeeping
                }
                else {
                    bodyContent += '<tr>';
                    bodyContent += '<td colspan="5">'+ wp_motive.message_no_data +'</td>';
                    bodyContent += '</tr>';
                    wpMotiveTableBody.html( bodyContent );
                    bodyContent = ''; // Housekeeping
                }
            });
        }
        else if( wp_motive_data_loaded_status === "yes" && wp_motive_users_data_override === "yes" ){
            $.when( endPointRequest( endPoint, wpMotiveTableBody ) ).done( function ( result ) {

                if ( result !== undefined ) {
                    for( var key in result.data.rows ) {
                        if( result.data.rows.hasOwnProperty( key ) ){
                            var unixTimeStamp = result.data.rows[key].date;
                            var userDate      = readableDate(unixTimeStamp);
                            var id            = result.data.rows[key].id;
                            var fname         = result.data.rows[key].fname;
                            var lname         = result.data.rows[key].lname;
                            var email         = result.data.rows[key].email;
                            var user          = {};

                            bodyContent += '<tr>';
                            bodyContent += '<td>'+ result.data.rows[key].id +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].fname +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].lname +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].email +'</td>';
                            bodyContent += '<td>'+ userDate +'</td>';
                            bodyContent += '</tr>';
                            // We need to persist the information until the next reload.
                            user.id    = id;
                            user.fname = fname;
                            user.lname = lname;
                            user.email = email;
                            user.date  = userDate;
                            // Add it to the array
                            usersData.push(user);
                        }
                    }
                    wpMotiveTableBody.html( bodyContent );
                    // Update Plugin Option
                    updatePluginOption( optionsForm, 'wp_motive_data_loaded_status', 'yes' );
                    updatePluginOption( optionsForm, 'wp_motive_users_data_override', 'no' );
                    cacheEndpointData( optionsForm, usersData );
                    updateLoadedTableTime( optionsForm );
                    $('.wp-motive-notification').text( wp_motive.message_cli_loaded );
                    bodyContent = ''; // Housekeeping
                }
                else {
                    bodyContent += '<tr>';
                    bodyContent += '<td colspan="5">'+ wp_motive.message_no_data +'</td>';
                    bodyContent += '</tr>';
                    wpMotiveTableBody.html( bodyContent );
                    bodyContent = ''; // Housekeeping
                }
            });
        }
        else if( wp_motive_data_loaded_status === "yes" ){ //data already retrieved from endpoint, so load it from local
            $.when( reloadCachedTable(optionsForm, wpMotiveTableBody) ).done( function ( result ) {
                var usersData = null;

                if ( result !== undefined ) {
                    // first let us convert the value to o valid JSON
                    usersData = JSON.parse( result.data.users_data );

                    for( var key in usersData ) {
                        if( usersData.hasOwnProperty( key ) ){
                            bodyContent += '<tr>';
                            bodyContent += '<td>'+ usersData[key].id +'</td>';
                            bodyContent += '<td>'+ usersData[key].fname +'</td>';
                            bodyContent += '<td>'+ usersData[key].lname +'</td>';
                            bodyContent += '<td>'+ usersData[key].email +'</td>';
                            bodyContent += '<td>'+ usersData[key].date +'</td>';
                            bodyContent += '</tr>';
                        }
                    }
                    wpMotiveTableBody.html( bodyContent );
                    $('.wp-motive-notification').text( wp_motive.message_cache_loaded );
                    bodyContent = ''; // Housekeeping
                }
                else {
                    bodyContent += '<tr>';
                    bodyContent += '<td colspan="5">'+ wp_motive.message_no_data +'</td>';
                    bodyContent += '</tr>';
                    wpMotiveTableBody.html( bodyContent );
                    bodyContent = ''; // Housekeeping
                }
            });
        }
    });

    function endPointRequest( _endPoint, _wpMotiveTableBody )
    {
        return $.ajax({
            url: _endPoint,
            type: 'get',
            dataType: 'json',
            beforeSend: function (){
                var bodyContent = '<tr>';
                bodyContent += '<td colspan="5"><span class="ajax-loader"></span></td>';
                bodyContent += '</tr>';
                _wpMotiveTableBody.html(bodyContent);
            }
        });
    }

    function reloadCachedTable( _optionsForm, _wpMotiveTableBody )
    {
        var nonce = _optionsForm.find('input[name="wp_motive_nonce_update_options"]').val();
        var data = {
            "security": nonce,
            "action": "wp_motive_load_cache_data"
        };

        return $.ajax({
            type: "post",
            url: wp_motive.ajax_url,
            dataType: "json",
            data: data,
            beforeSend: function (){
                var bodyContent = '<tr>';
                bodyContent += '<td colspan="5"><span class="ajax-loader"></span></td>';
                bodyContent += '</tr>';
                _wpMotiveTableBody.html(bodyContent);
            }
        });
    }

    function updateLoadedTableTime(_optionsForm)
    {
        var nonce = _optionsForm.find('input[name="wp_motive_nonce_update_options"]').val();
        var data = {
            "security": nonce,
            "action": "wp_motive_loaded_table_time"
        };

        $.ajax({
            type: "post",
            url: wp_motive.ajax_url,
            dataType: "json",
            data: data
        }).done(function(result) {
            if(typeof result === "object" && result.success === true){
                console.log("Time Recorded Successfully.!!");
                console.log(result);

            }
            else if(typeof result === "object" && result.success === false){
                console.log("Could not retrieve information.!!");
                console.log(result);

            }
        }).fail(function ( xhr, status, error) {
            // Something wrong on the server side.
            // console.log("Fail status: ");
            // console.log(status);
            // console.log("Fail error: ");
            // console.log(error);
        });
        // console.log(wp_motive);
    }

    function updatePluginOption( _optionsForm, _option_name, _option_value )
    {
        var nonce = _optionsForm.find('input[name="wp_motive_nonce_update_options"]').val();
        var data = {
            "security": nonce,
            "action": "wp_motive_update_options",
            "option_name": _option_name,
            "option_value": _option_value
        };

        $.ajax({
            type: "post",
            url: wp_motive.ajax_url,
            dataType: "json",
            data: data
        }).done(function(result) {
            if(typeof result === "object" && result.success === true){
                console.log("Table Loaded Successfully.!!");
                console.log(result);

            }
            else if(typeof result === "object" && result.success === false){
                console.log("Could not retrieve information.!!");
                console.log(result);

            }
        }).fail(function ( xhr, status, error) {
            // Something wrong on the server side.
            // console.log("Fail status: ");
            // console.log(status);
            // console.log("Fail error: ");
            // console.log(error);
        });
        // console.log(wp_motive);
    }

    function cacheEndpointData( _optionsForm, _usersData )
    {
        var nonce = _optionsForm.find('input[name="wp_motive_nonce_update_options"]').val();
        var data = {
            "security": nonce,
            "action": "wp_motive_cache_data",
            "users_data": JSON.stringify(_usersData)
        };

        $.ajax({
            type: "post",
            url: wp_motive.ajax_url,
            dataType: "json",
            data: data
        }).done(function(result) {
            if(typeof result === "object" && result.success === true){
                console.log("Table Cached Successfully.!!");
                console.log(result);

            }
            else if(typeof result === "object" && result.success === false){
                console.log("Could not retrieve information.!!");
                console.log(result);

            }
        }).fail(function ( xhr, status, error) {
            // Something wrong on the server side.
            // console.log("Fail status: ");
            // console.log(status);
            // console.log("Fail error: ");
            // console.log(error);
        });
    }

    function readableDate( _unixTimeStamp )
    {
        // Convert timestamp to milliseconds
        var date = new Date( _unixTimeStamp * 1000 );
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = date.getFullYear();
        var month = months[date.getMonth()];
        var day = date.getDate();

        return day + '-' + month + '-' + year;
    }
})(jQuery);
