/**
 * Main Script for the Admin Area
 * @since 02-Dic-2019
 * @version 1.0.0
 * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
(function($) {
    'use strict';
    $(document).ready(function (){
        var endPoint = 'https://miusage.com/v1/challenge/1/';
        var wpMotiveTableBody = $('.wp-motive-table-data tbody');
        var bodyContent = '';
        var tableReloadStatus = 1;
        var tableReloadSchedule = false;
        $('.reload-data-container .btn-reload-data').on('click', reloadTable);

        $.when( endPointRequest( endPoint, wpMotiveTableBody ) ).done( function ( result ) {

            if ( result !== undefined ) {
                for( var key in result.data.rows ) {
                    if( result.data.rows.hasOwnProperty( key ) ){
                        var unixTimeStamp = result.data.rows[key].date;
                        var userDate = readableDate(unixTimeStamp);

                        bodyContent += '<tr>';
                            bodyContent += '<td>'+ result.data.rows[key].id +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].fname +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].lname +'</td>';
                            bodyContent += '<td>'+ result.data.rows[key].email +'</td>';
                            bodyContent += '<td>'+ userDate +'</td>';
                        bodyContent += '</tr>';
                    }
                }
                wpMotiveTableBody.html( bodyContent );
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
    });

    function endPointRequest( _endPoint, _wpMotiveTableBody ) {
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

    function reloadTable(){

    }

    function readableDate( _unixTimeStamp ){
        // Convert timestamp to milliseconds
        var date = new Date( _unixTimeStamp * 1000 );
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = date.getFullYear();
        var month = months[date.getMonth()];
        var day = date.getDate();

        return day + '-' + month + '-' + year;
    }
})(jQuery);
