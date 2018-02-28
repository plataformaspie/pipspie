@extends('layouts.moduloplanificacion')

@section('header')


@endsection

@section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Estructura Institucional</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Estructura Institucional</li>
      </ol>
  </div>
  <div class="topbar-right">
      <div class="ml15 ib va-m" id="toggle_sidemenu_r">
          <a href="#" class="pl5"> <i class="fa fa-sign-in fs22 text-primary"></i>
              <span class="badge badge-hero badge-danger">3</span>
          </a>
      </div>
  </div>
@endsection

@section('content')

  <?php /*<aside class="tray tray-left tray290 va-t pn" data-tray-height="match">

      <!-- menu quick links -->
      <div class="p20 admin-form">

          <h4 class="mt5 text-muted fw500"> Registro</h4>

          <hr class="short">

          <div class="section mb15">
              <label for="order-id" class="field prepend-icon">
                  <input type="text" name="order-id" id="order-id" class="gui-input" placeholder="Product SKU #">
                  <label for="order-id" class="field-icon"><i class="fa fa-tag"></i>
                  </label>
              </label>
          </div>

          <h6 class="fw400">Price Range($)</h6>
          <div class="section row mb15">
              <div class="col-md-6">
                  <label for="price1" class="field prepend-icon">
                      <input type="text" name="price1" id="price1" class="gui-input" placeholder="0">
                      <label for="price1" class="field-icon"><i class="fa fa-usd"></i>
                      </label>
                  </label>
              </div>
              <div class="col-md-6">
                  <label for="price2" class="field prepend-icon">
                      <input type="text" name="price2" id="price2" class="gui-input" placeholder="1000">
                      <label for="price2" class="field-icon"><i class="fa fa-usd"></i>
                      </label>
                  </label>
              </div>
          </div>

          <h6 class="fw400">Sales Date</h6>
          <div class="section row">
              <div class="col-md-6">
                  <label for="date1" class="field prepend-icon">
                      <input type="text" name="date1" id="date1" class="gui-input" placeholder="01/01/15">
                      <label for="date1" class="field-icon"><i class="fa fa-calendar"></i>
                      </label>
                  </label>
              </div>
              <div class="col-md-6">
                  <label for="date2" class="field prepend-icon">
                      <input type="text" name="date2" id="date2" class="gui-input" placeholder="01/31/15">
                      <label for="date2" class="field-icon"><i class="fa fa-calendar"></i>
                      </label>
                  </label>
              </div>
          </div>

          <h6 class="fw400">Search Categories</h6>
          <div class="section mb15">
              <label class="field select">
                  <select id="filter-categories" name="filter-categories">
                      <option value="0" selected="selected">Filter by Categories</option>
                      <option value="1">Electronics</option>
                      <option value="2">Software</option>
                  </select>
                  <i class="arrow double"></i>
              </label>
          </div>

          <h6 class="fw400">Search Customers</h6>
          <div class="section mb15">
              <label class="field select">
                  <select id="filter-customers" name="filter-customers">
                      <option value="0" selected="selected">Filter by Vendor</option>
                      <option value="1">Michael</option>
                      <option value="2">David</option>
                      <option value="3">Sara</option>
                      <option value="4">Tasha</option>
                  </select>
                  <i class="arrow double"></i>
              </label>
          </div>

          <hr class="short">

          <div class="section row">
              <div class="col-sm-12">
                  <button class="btn btn-default btn-sm ph25" type="button">Search</button>
                  <label class="field option ml15">
                      <input type="checkbox" name="info">
                      <span class="checkbox"></span> <span class="text-muted">Save Search</span>
                  </label>
              </div>
              <div class="col-sm-7 hidden">
                  <label class="field option mt10">
                      <input type="checkbox" name="info" checked>
                      <span class="checkbox"></span>Save Search
                  </label>
              </div>
          </div>

      </div>

  </aside>*/ ?>

  <div class="tray tray-center p25 va-t posr">

      <!-- create new order panel -->
      <div class="panel">
          <div class="panel-heading text-center">
               <span class="panel-title"> Listado de entidades registradas</span>
          </div>
          <div class="panel-body">
              <div class="row">
                  <div class="col-md-12">
                        x
                  </div>
              </div>
          </div>
      </div>



  </div>



@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){
      activarMenu('1','24');
      activarMenu('2','0');

    });
  </script>
@endpush
