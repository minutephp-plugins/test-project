function buy(ele) {
    var e = $(ele);
    var package_id = e.data('package-id') || 0;

    $('#buyModal' + package_id).modal('show');
    $.post('/_auth/trigger_user_event', {eventName: 'user_payment_expect', eventData: {package_id: package_id}});

    plan($('h3.price').data('cycle'));
}

function plan(mode) {
    var toggleMode = mode == 'yearly' ? 'monthly' : 'yearly';
    $('.plan_' + mode).removeClass('hide');
    $('.plan_' + toggleMode).addClass('hide');

    loadVouchers();
}

function addVoucher() {
    $('#voucher').fadeIn();
}

function applyVoucher() {
    var code = $('#code').val();

    if (code) {
        $.post('/_payments/vouchers/apply', {code: code}).then(loadVouchers, function (err) { notice(err.responseText, 'error'); });
    } else {
        notice('Please enter your voucher code in the box first.');
    }
}

function notice(msg, type) {
    alertify.logPosition("top right");
    alertify.log(msg, type || 'success')
}

function loadVouchers() {
    $('div.voucher-alert, div.voucher-box').css('display', 'none');

    $.getJSON('/_payments/vouchers/load').then(function (obj) {
            if (obj && obj.vouchers && obj.vouchers.length > 0) {
                $('a.purchase:visible').each(function () {
                    var href = $(this).attr('href');
                    angular.forEach(obj.vouchers, function (voucher) {
                        console.log("voucher: ", voucher, href);
                        if (href.indexOf('/purchase/' + voucher.product_id + '/') !== -1) {
                            $('div.voucher-alert').fadeIn().find('span.comment').html(voucher.comment);
                        }
                    });
                });
            }
        }
    )
}

function checkout(ele, processor) {
    $('div.modal').modal('hide');
    $('#loadingModal').modal('show');
}
