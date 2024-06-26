@extends('admin.layout.layout')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-6 ">

                                <h4 class="text-capitalize">Data User</h4>
                            </div>
                            <div class="col-6 text-end">
                            </div>
                        </div>

                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">

                        </div>
                    </div>
                </div>


                            <div class="row">
                                <div class="col-md-8 mt-4">
                                  <div class="card">
                                    <div class="card-header pb-0 px-3">
                                      <h6 class="mb-0">Order Detail</h6>
                                    </div>
                                    <div class="card-body pt-4 p-3">
                                      <ul class="list-group">
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 border-radius-lg">
                                          <div class="d-flex flex-column">

                                            <div >
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px; ">Order ID</span>:
                                                    <span class="text-dark ms-sm-2">{{ $order->order_id }}</span>
                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Customer Name</span>:
                                                    <span class="text-dark ms-sm-2">{{ $order->customer->name }}</span>
                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Serial Number</span>:
                                                    @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->serial_number }};</td>
                                                    </tr>
                                                    @endforeach

                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                  <span style="display: inline-block; width: 150px;">FeederType</span>:
                                                  <tr>
                                                      <td>{{ $order->items->first()->cobox_name ?? 'No cobox' }}</td>
                                                  </tr>
                                              </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Feeder Name</span>:
                                                    @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->cobox_id }};</td>
                                                    </tr>
                                                    @endforeach
                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Order Quantity</span>:
                                                    <span class="text-dark ms-sm-2">{{ $order->getTotalQuantityAttribute() }}</span>
                                                </div>
                                            </div>

                                          </div>


                                    </div>
                                  </div>
                                </div>

                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 mt-4">
                                  <div class="card">
                                    <div class="card-header pb-0 px-3">
                                      <h6 class="mb-0">Shipment Detail</h6>
                                    </div>
                                    <div class="card-body pt-4 p-3">
                                      <ul class="list-group">
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 border-radius-lg">
                                          <div class="d-flex flex-column">

                                            <div >
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px; ">
                                                      Receiver Name</span>:
                                                    <span class="text-dark  ms-sm-2">{{ $shipment->user->username }}</span>
                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Receiver Contact</span>:
                                                    <span class="text-dark ms-sm-2 ">{{ $shipment->user->email }}</span>
                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                  <span style="display: inline-block; width: 150px;">Point</span>:
                                                  <span class="text-dark ms-sm-2 ">{{ $shipment->point->point_name }}</span>
                                              </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Shipment Address	</span>:
                                                    <span class="text-dark ms-sm-2 ">{{ $shipment->shipment_address }}</span>
                                                </div>
                                                <div style="margin-bottom: 16px;">
                                                    <span style="display: inline-block; width: 150px;">Shipment Date</span>:
                                                    <span class="text-dark ms-sm-2 ">{{ \Carbon\Carbon::parse($shipment->shipment_date)->format('d F Y') }}</span>
                                                </div>

                                            </div>

                                          </div>


                                    </div>
                                  </div>
                                </div>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col">
            <div class="card ">
                <div class="card-header pb-3">
                    <div class="row justify-content-between"> <!-- Menggunakan flexbox untuk distribusi merata -->
                        <div class="col-auto"> <!-- Menggunakan col-auto untuk size otomatis berdasar konten -->
                            <a class="btn bg-gradient-success mb-0 btn-block" href="{{ route('DeliveryOrder') }}">&nbsp;&nbsp;Back</a>
                        </div>
                        <div class="col-auto">
                            @if($order->status == 'Shipped')
                                <form action="{{ route('finishDelivery', ['orderId' => $order->order_id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success" onclick="showFinishConfirmation(event)">Finish Delivery</button>
                                </form>
                            @elseif($order->status == 'Pending')
                                <form action="{{ route('acceptOrder', ['orderId' => $order->order_id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success" onclick="showAcceptedConfirmation(event)">Accept Order</button>
                                </form>
                                <form action="{{ route('cancelOrder', ['orderId' => $order->order_id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="showCancelConfirmation(event)">Cancel Order</button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
  // Fungsi untuk menampilkan tabel berdasarkan ID
  function showTable(tableId) {
    // Sembunyikan semua tabel
    var tables = document.getElementsByClassName('table-container');
    for (var i = 0; i < tables.length; i++) {
      tables[i].style.display = 'none';
    }

    // Tampilkan tabel yang sesuai
    var tableToShow = document.getElementById(tableId);
    if (tableToShow) {
      tableToShow.style.display = 'block';
    }
  }

  // Tampilkan tabel A secara otomatis
  showTable('Workshop');
</script>

<script>
    function submitFormAndDisableButton(form) {
        form.submit(); // Submit form
        form.querySelector('button[type="submit"]').disabled = true; // Disable the submit button
    }
    </script>

@endsection
