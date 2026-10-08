(function () {

$(document).ready(function() {
    const $page =$('#orders-page');
    const dataUrl = $page.data('data-url');
    $('#order-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: dataUrl,
            type: 'GET'
        },
        columns: [
            {data: 'id'},
            {data: 'customer_name'},
            {data: 'address'},
            {data: 'payment_method'},
            {data: 'total_price'},
            {
                data: 'status',
                render: function (data) {
                    let badgeClass = 'badge-pending';
                    const statusLower = data.toLowerCase();
                    if (statusLower === 'completed' || statusLower === 'success') {
                        badgeClass = 'badge-success';
                    } else if (statusLower === 'canceled' || statusLower === 'failed') {
                        badgeClass = 'badge-danger';
                    }
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            {data: 'created_at'}
        ],
        order: [[0, 'desc']],
        language: {
            search: "Cari Order:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Tampilkan _START_ sampai _END_ dari _TOTAL_ order",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Lanjut",
                previous: "Kembali"
            },
            emptyTable: "Belum ada data order"
        }
    });
});
})();