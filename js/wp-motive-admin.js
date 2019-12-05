/**
 * Main Script for the Admin Area
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
        var wp_motive_request_period     = optionsForm.find('input[name="wp_motive_request_period"]').val();
        var usersData                    = [];
        var self = this;
        $('.reload-data-container .btn-reload-data').on('click', reloadTable);

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
                            // Add it to the array
                            usersData.push(user);
                        }
                    }
                    wpMotiveTableBody.html( bodyContent );
                    // Update Plugin Option
                    updatePluginOption(optionsForm, 'wp_motive_data_loaded_status', 'yes' );
                    cacheEndpointData( usersData );
                    bodyContent = ''; // Housekeeping
                }
                else {
                    bodyContent += '<tr>';
                    bodyContent += '<td colspan="5">No data to show</td>';
                    bodyContent += '</tr>';
                    wpMotiveTableBody.html( bodyContent );
                    bodyContent = ''; // Housekeeping
                }
            });
        }
        else if( wp_motive_data_loaded_status === "yes" ){ //data already retrieved from endpoint, so load it from local

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

    function reloadTable()
    {

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

    function cacheEndpointData( _cacheEndpointData )
    {
        console.log(_cacheEndpointData);
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
