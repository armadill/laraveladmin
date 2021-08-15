@extends('layouts.app')
@section('content')
<div class="container-fluid">
<div class="row justify-content-center">
   @if(Auth::user()->email == 'alman.bpp@gmail.com')
   <div class="col-md-12">
      <div class="card card-primary collapsed-card">
         <div class="card-header">
            <h3 class="card-title">Expandable</h3>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
               </button>
            </div>
            <!-- /.card-tools -->
         </div>
         <!-- /.card-header -->
         <div class="card-body" style="display: none;">
            <form action="{{url('postsewa')}}" method="post">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group container-fluid">
                        <label>Nama Domain</label>
                        <input type="text" class="form-control" name="txtdomain">
                     </div>
                     <div class="form-group container-fluid">
                        <label>Harga Sewa</label>
                        <input type="number" class="form-control" name="txtharga">
                     </div>
                     <div class="form-group container-fluid">
                        <label>Max User</label>
                        <input type="number" class="form-control" name="txtmax">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group container-fluid">
                        <label>Tgl Mulai</label>
                        <input type="date" class="form-control" name="txttgl1">
                     </div>
                     <div class="form-group container-fluid">
                        <label>Tgl Selesai</label>
                        <input type="date" class="form-control" name="txttgl2">
                     </div>
                     <div class="form-group container-fluid">
                        <label>No Tlp</label>
                        <input type="number" class="form-control" name="txtnope">
                     </div>
                     <div class="form-group container-fluid">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group container-fluid">
                        <label>Ket</label>
                        <textarea class="form-control" rows="3" name="txtket"></textarea>
                     </div>
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="txtface">
                        <label class="form-check-label" for="exampleCheck1">
                           Face
                     </div>
                     <div class="form-check">
                     <input type="checkbox" class="form-check-input" name="txttele" id="exampleCheck1">
                     <label class="form-check-label" for="exampleCheck1" >Telegram</label>
                     </div>
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input"  name="txtlock" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Lock Domain</label>
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <div class="table-responsive">
               <table id="sewanya" width="100%" style="text-align: center;" class="table-sm table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Domain</th>
                        <th>Harga</th>
                        <th>Harga X</th>
                        <th>Max user</th>
                        <th align="right">Total</th>
                        <th>Tgl</th>
                        <th>Tersisa</th>
                        <th>TLp</th>
                        <th>Ket</th>
                        <th>API key</th>
                        <th>Fitur</th>
                        <th>Action</th>
                     </tr>
                  </thead>
               </table>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>
      <div class="col-md-12">
         <div class="card card-primary collapsed-card">
            <div class="card-header">
               <h3 class="card-title">APP</h3>
               <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
               </div>
               <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <form action="{{url('postapp')}}" method="post">
                  @csrf
                  <div class="form-group container-fluid">
                     <label>Url Splash</label>
                     <input type="text" class="form-control" name="txtsplash">
                  </div>
                  <div class="form-group container-fluid">
                     <label>Durasi Splash</label>
                     <input type="text" class="form-control" name="txtdurasi">
                  </div>
                  <div class="form-group container-fluid">
                     <label>Url Base</label>
                     <input type="text" class="form-control" name="txtdomain">
                  </div>
                  <div class="form-group container-fluid">
                     <label>Maintnance</label>
                     <input type="text" class="form-control" name="txtmaintain">
                  </div>
                  <div class="form-group container-fluid">
                     <label>Warna</label>
                     <input type="text" class="form-control" name="txtwarna">
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
               </form>
               <br>
               <div class="table-responsive">
                  <table id="tabelapp" style="text-align: center;" class="table table-sm table-bordered table-striped">
                     <tr>
                        <th>Client</th>
                        <th>Splash</th>
                        <th>Durasi</th>
                        <th>Home</th>
                        <th>Maintenance</th>
                        <th>Info Maintenance</th>
                        <th>Warna</th>
                        <th>Aksi</th>
                     </tr>
                     @foreach ($dataapp as $data)
                     <tr>
                        <td>{{$data->client}}</td>
                        <td>{{$data->urlsplash}}</td>
                        <td>{{$data->durasisplash}}</td>
                        <td>{{$data->urlbase}}</td>
                        <td>{{$data->maintain}}</td>
                        <td>{{$data->info}}</td>
                        <td>{{$data->warna}}</td>
                        <td><a href="#" class="btn btn-success btn-sm">Edit</a></td>
                     </tr>
                     @endforeach
                  </table>
               </div>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>

      <div class="col-md-12">
         <div class="card card-primary collapsed-card">
            <div class="card-header">
               <h3 class="card-title">BROADCAST</h3>
               <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
               </div>
               <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{url('postwablast')}}" method="post">
                @csrf
                 <div class="form-group container-fluid">
                        <label>No Pengirim</label>
                        <input type="text" class="form-control" name="txtsender">
                     </div>
                      <div class="form-group container-fluid">
                        <label>Token</label>
                        <input type="text" class="form-control" name="txttoken">
                     </div>
                      <div class="form-group container-fluid">
                        <label>Link API</label>
                        <input type="text" class="form-control" name="txtlink">
                     </div>
                      <div class="form-group container-fluid">
                        <label>Limit Kirim / Nomor</label>
                        <input type="text" class="form-control" name="txtlimit">
                     </div>
                      <div class="form-group container-fluid">
                        <label>Isi Pesan</label>
                        <textarea class="form-control" name="txtisiwablast" rows="6"></textarea>
                     </div>
                     <div class="form-group container-fluid">
                        <button type="submit" class="btn btn-primary">Kirim Jadwal</button>
                     </div>
              </form>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>



      @endif
   </div>
</div>
@endsection
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<!-- sweet alert -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<style type="text/css">
   .aksi ul{
   list-style: none;
   }
   .warnaform {
   background: white !important;
   border: 0px solid white !important;
   font-weight: bold  !important;
   font-size: 23px  !important;
   color:#724545;
   }
</style>
@endsection
@section('js')
<!-- DataTables -->
<script src="{{url('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- data table js -->
<!-- SweetAlert2 -->
<script src="{{url('/adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
   $(function () {
    var table = $("#tabelapp").DataTable({
      "responsive": true,
      "ScrollX": true,
      "ScrollY": true,
      "autoWidth": true,
      "searching": true,
      "paging": true,
      "lengthChange": true,
      "ordering": true,
      "info": true,
         order : [[0,'DESC']]
    });
   
   });
</script>
<script>
   $(function() {
    var t =   $('#sewanya').DataTable({
     responsive: true,
     ScrollX: true,
     autoWidth: false,
     searching: true,
     paging: true,
     lengthChange: true,
     ordering: true,
     info: true,
     processing: true,
     serverSide: true,
     
     ajax: "{{route('ajax.load.tabelsewa')}}",
     columns: [
     { data: 'domain', name: 'domain'},
     { data: 'domain', name: 'domain'},
     { data: 'harga', name: 'harga'},
     { data: 'hargax', name: 'hargax'},
     { data: 'maxuser', name: 'maxuser'},
     { data: 'total', name: 'total'},
     { data: 'tgl', name: 'tgl'},
     { data: 'sisa', name: 'sisa'},
     { data: 'nope', name: 'nope'},
     { data: 'ket', name: 'ket'},
     { data: 'key', name: 'key'},
     { data: 'face', name: 'face'},
     { data: 'aksi', name: 'aksi'},
     
   
   
     ],
     order : [[1,'DESC']]
   });
   
    t.on( 'order.dt search.dt', function () {
     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
       cell.innerHTML = i+1;
     } );
   } ).draw();
   
   
   });
</script>
<!-- untuk proses hapus  -->
<div class="modal  fade" id="hapus" tabindex="-1" role="dialog" data-backdrop="static">
   <div class="modal-dialog  " role="document">
      <div class="modal-content">
         <div class="modal-header bg-danger">
            <h4 class="modal-title" id="defaultModalLabel">Hapus data</h4>
         </div>
         <div class="modal-body">
            <br>
            <form action="{{url('hapusdatadomain')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" id="txtid" name="txtid" class="form-control">
               <div class="form-group">
                  <h4>Yakin ingin menghapus data ?</h4>
                  <label>Domain</label>
                  <input autocomplete="off" name="txtnama" disabled="true" type="text" required="true" id="txtnama" class=" warnaform form-control"  />
               </div>
         </div>
         <div class="modal-footer">
         <button type="submit" class="btn bg-red waves-effect">Ya, Hapus</button>
         <button type="button" class="btn bg-secondary waves-effect" data-dismiss="modal">Batalkan</button>
         </div>
         </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   $('#hapus').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget)
     var txtid = button.data('txtid') 
     var txtnama = button.data('txtnama') 
   
     var modal = $(this)
     modal.find('.modal-body #txtid').val(txtid)
     modal.find('.modal-body #txtnama').val(txtnama)
   })
</script>
<!-- untuk proses push  -->
<div class="modal  fade" id="push" tabindex="-1" role="dialog" data-backdrop="static">
   <div class="modal-dialog  " role="document">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <h4 class="modal-title" id="defaultModalLabel">Kirim Tagihan Invoice</h4>
         </div>
         <div class="modal-body">
            <br>
            <form action="{{url('postkirimtagihan')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" id="txtid" name="txtid" class="form-control">
               <div class="form-group">
                  <label>Domain</label>
                  <input autocomplete="off" name="txtnama" disabled="true" type="text" required="true" id="txtnama" class=" warnaform form-control"  />
               </div>
         </div>
         <div class="modal-footer">
         <button type="submit" class="btn bg-primary waves-effect">Kirim</button>
         <button type="button" class="btn bg-secondary waves-effect" data-dismiss="modal">Batalkan</button>
         </div>
         </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   $('#push').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget)
     var txtid = button.data('txtid') 
     var txtnama = button.data('txtnama') 
   
     var modal = $(this)
     modal.find('.modal-body #txtid').val(txtid)
     modal.find('.modal-body #txtnama').val(txtnama)
   })
</script>
<!-- untuk proses edit  -->
<div class="modal  fade" id="edit" tabindex="-1" role="dialog" data-backdrop="static">
   <div class="modal-dialog  " role="document">
      <div class="modal-content">
         <div class="modal-header bg-success">
            <h4 class="modal-title" id="defaultModalLabel">Edit data</h4>
         </div>
         <div class="modal-body">
            <br>
            <form action="{{url('updatesewa')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" id="txtid" name="txtid" class="form-control">
               <div class="col-md-12 row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Domain</label>
                        <input autocomplete="off" name="txtnama"  type="text" required="true" id="txtnama" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>Harga</label>
                        <input autocomplete="off" name="txtharga"  type="text" required="true" id="txtharga" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>Harga X</label>
                        <input autocomplete="off" name="txthargax"  type="text" required="true" id="txthargax" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>Max User</label>
                        <input autocomplete="off" name="txtmax"  type="text" required="true" id="txtmax" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>No Tlp</label>
                        <input autocomplete="off" name="txtnope"  type="text" required="true" id="txtnope" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>Email</label>
                        <input autocomplete="off" name="email"  type="text" required="true" id="email" class="form-control"  />
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Tgl Mulai</label>
                        <input autocomplete="off" name="txtmulai"  type="date" required="true" id="txtmulai" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>No Selesai</label>
                        <input autocomplete="off" name="txtselesai"  type="date" required="true" id="txtselesai" class="form-control"  />
                     </div>
                     <div class="form-group">
                        <label>No Selesai</label>
                        <textarea class="form-control" rows="2" id="txtket" name="txtket"></textarea>
                     </div>
                     <div class="form-check">
                        <input type="hidden" id="txtfacenya">
                        <input type="checkbox" class="form-check-input" id="face" name="txtface">
                        <label class="form-check-label" for="exampleCheck1">
                           Face
                     </div>
                     <div class="form-check">
                     <input type="hidden"  id="txttelenya">
                     <input type="checkbox" class="form-check-input" id="tele" name="txttele">
                     <label class="form-check-label" for="exampleCheck1" >Telegram</label>
                     </div>
                     <div class="form-check">
                        <input type="hidden"  id="txtlocknya">
                        <input type="checkbox" class="form-check-input" id="lock"  name="txtlock">
                        <label class="form-check-label" for="exampleCheck1">Lock Domain</label>
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer">
         <button type="submit" class="btn bg-success waves-effect">Ya, Update</button>
         <button type="button" class="btn bg-secondary waves-effect" data-dismiss="modal">Batalkan</button>
         </div>
         </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   $('#edit').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget)
     var txtid = button.data('txtid') 
     var txtnama = button.data('txtnama') 
     var txtharga = button.data('txtharga') 
     var txthargax = button.data('txthargax') 
     var txtmax = button.data('txtmax') 
     var txtnope = button.data('txtnope') 
     var email = button.data('email') 
     var txtmulai = button.data('txtmulai') 
     var txtselesai = button.data('txtselesai') 
     var txtket = button.data('txtket') 
     var txtfacenya = button.data('txtfacenya') 
     var txttelenya = button.data('txttelenya') 
     var txtlocknya = button.data('txtlocknya') 
     
     var modal = $(this)
     modal.find('.modal-body #txtid').val(txtid)
     modal.find('.modal-body #txtnama').val(txtnama)
     modal.find('.modal-body #txtharga').val(txtharga)
     modal.find('.modal-body #txthargax').val(txthargax)
     modal.find('.modal-body #txtmax').val(txtmax)
     modal.find('.modal-body #txtnope').val(txtnope)
     modal.find('.modal-body #email').val(email)
     modal.find('.modal-body #txtmulai').val(txtmulai)
     modal.find('.modal-body #txtselesai').val(txtselesai)
     modal.find('.modal-body #txtket').val(txtket)
     modal.find('.modal-body #txtfacenya').val(txtfacenya)
     modal.find('.modal-body #txttelenya').val(txttelenya)
     modal.find('.modal-body #txtlocknya').val(txtlocknya)
     
     if($('#txtfacenya').val() == "on") {
      $( "#face").prop('checked', true);
    }
    if($('#txttelenya').val() == "on") {
      $( "#tele").prop('checked', true);
    }
    if($('#txtlocknya').val() == "on") {
      $( "#lock").prop('checked', true);
    }
   
   
   })
</script>
@if(Session('gagal'))
<script>
   Swal.fire({
    icon: 'error',
    title: 'Status...',
    text: '{{Session::get('gagal')}}'
   })
</script>
@endif 
@if(Session('sukses'))
<script>
   Swal.fire({
    icon: 'success',
    title: 'Status...',
    showConfirmButton: false,
    html: '<b>{{Session::get('sukses')}}</b>'
   })
</script>
@endif
@endsection