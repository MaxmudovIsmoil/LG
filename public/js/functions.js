
/**
 * Number format
 * 12340 --> 12 340
 */
function number_format(number) {
    return number.toLocaleString('ru-RU')
}

//  ################## templates ####################

// day = day, month, year;
function date_day_month_year_change(day, val) {
    $('.js_date_'+day+'_static').html(val)
}

