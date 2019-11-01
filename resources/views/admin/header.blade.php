<?php 

  $b = DB::select("select SUM(stoks.stok) as count, obats.nama_obat, obats.perusahaan, stoks.obat_id, stoks.id as id_stok 
  from stoks join obats on stoks.obat_id = obats.obat_id 
  where obats.status = 1
  group by stoks.obat_id
  HAVING SUM(stoks.stok) <= 5 
  union
  SELECT min(stk.stok) as count, obats.nama_obat, obats.perusahaan, obats.obat_id, stk.id as id_stok
  FROM  (SELECT sum(stok) stok, obat_id, id FROM stoks GROUP BY obat_id) stk 
  JOIN det_racikans ON det_racikans.id_obat = stk.obat_id
  JOIN obats on obats.obat_id = det_racikans.id_racikan
  WHERE det_racikans.id_racikan in (SELECT obat_id FROM obats WHERE kategori = 'MRACIK' AND status = 1)
  HAVING SUM(stk.stok) <= 5");
  $count = count($b);  
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">{{$count}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          @foreach($b as $dta)
            <a href="{{route('stoks.create')}}" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    {{$dta->nama_obat}}
                  </h3>
                  <p class="text-sm">Sisa Stok</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{$dta->count}}</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
          @endforeach
        </div>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>