<?php

use kcfinder\session;

$dateExport = date("d-m-Y");

if (isset($_POST["testA1"])) {
  _getExistanceUser("407007802B", "HW0101", "outside", "1");
} else if (isset($_POST["testB1"])) {
  _getExistanceUser("7309D03D0B", "HW0101", "outside", "1");
} else if (isset($_POST["testC1"])) {
  _getExistanceUser("730DE0530B", "HW0101", "outside", "1");
} else if (isset($_POST["testD1"])) {
  _getExistanceUser("8704609F05F", "HW0101", "outside", "1");
} else if (isset($_POST["testA2"])) {
  _getExistanceUser("407007802B", "HW0102", "outside", "1");
} else if (isset($_POST["testB2"])) {
  _getExistanceUser("7309D03D0B", "HW0102", "outside", "1");
} else if (isset($_POST["testC2"])) {
  _getExistanceUser("730DE0530B", "HW0102", "outside", "1");
} else if (isset($_POST["testD2"])) {
  _getExistanceUser("8704609F05F", "HW0102", "outside", "1");
} else if (isset($_POST["testA3"])) {
  _getExistanceUser("407007802B", "HW0103", "outside", "1");
} else if (isset($_POST["testB3"])) {
  _getExistanceUser("7309D03D0B", "HW0103", "outside", "1");
} else if (isset($_POST["testC3"])) {
  _getExistanceUser("730DE0530B", "HW0103", "outside", "1");
} else if (isset($_POST["testD3"])) {
  _getExistanceUser("8704609F05F", "HW0103", "outside", "1");
}
else if (isset($_POST["testAL1"])) {
  _getExistanceUser("407007802B", "HW0101", "outside", "2");
} else if (isset($_POST["testAD1"])) {
  _getExistanceUser("407007802B", "HW0101", "inside", "2");
} else if (isset($_POST["testBL1"])) {
  _getExistanceUser("7309D03D0B", "HW0101", "outside", "2");
} else if (isset($_POST["testBD1"])) {
  _getExistanceUser("7309D03D0B", "HW0101", "inside", "2");
} else if (isset($_POST["testAL2"])) {
  _getExistanceUser("407007802B", "HW0102", "outside", "2");
} else if (isset($_POST["testAD2"])) {
  _getExistanceUser("407007802B", "HW0102", "inside", "2");
} else if (isset($_POST["testBL2"])) {
  _getExistanceUser("7309D03D0B", "HW0102", "outside", "2");
} else if (isset($_POST["testBD2"])) {
  _getExistanceUser("7309D03D0B", "HW0102", "inside", "2");
}

if (empty($_SESSION['tabtest'])){
  $paneTabStatus1 = "active";
  $paneTabStatus2 = "";
} else {
  if ($_SESSION['tabtest'] == "1"){
    $paneTabStatus1 = "active";
    $paneTabStatus2 = "";
  }else if ($_SESSION['tabtest'] == "2"){
    $paneTabStatus1 = "";
    $paneTabStatus2 = "active";
  }
}

?>
<section class="content-header">
  <div class="container-fluid">

    <div class="row mb-2">
      <div class="col-sm-6">
        <h3><i class="fas fa-user-tie"></i></h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active"></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus1 ?>" href="#testvone" data-toggle="tab">Tester V1</a></li>
          <li class="nav-item"><a class="nav-link <?php echo $paneTabStatus2 ?>" href="#testvtwo" data-toggle="tab">Tester V2</a></li>
        </ul>
      </div><!-- /.card-header -->

      <div class="card-body">
        <div class="tab-content">
          <div class="<?php echo $paneTabStatus1 ?> tab-pane" id="testvone">
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>Alpha</h3>
                    <p>Pintu 1</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testA1" name="testA1" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Beta</sup></h3>
                    <p>Pintu 1</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testB1" name="testB1" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Gamma</h3>
                    <p>Pintu 1</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testC1" name="testC1" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>Delta</h3>
                    <p>Pintu 1</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testD1" name="testD1" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ------------------------------------------------>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>Alpha</h3>
                    <p>Pintu 2</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testA2" name="testA2" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Beta</sup></h3>
                    <p>Pintu 2</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testB2" name="testB2" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Gamma</h3>
                    <p>Pintu 2</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testC2" name="testC2" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>Delta</h3>
                    <p>Pintu 2</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testD2" name="testD2" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ------------------------------------------------>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>Alpha</h3>
                    <p>Pintu 3</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testA3" name="testA3" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Beta</sup></h3>
                    <p>Pintu 3</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testB3" name="testB3" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Gamma</h3>
                    <p>Pintu 3</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testC3" name="testC3" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>Delta</h3>
                    <p>Pintu 3</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testD3" name="testD3" class="btn-light btn-sm">Click Here &nbsp;<i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ------------------------------------------------>
              <!-- ./col -->
            </div>
            <!-- /.tab-pane -->
          </div>
          <div class="<?php echo $paneTabStatus2 ?> tab-pane" id="testvtwo">
          <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>Alpha</h3>
                    <p>Pintu 1 (Luar)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testAL1" name="testAL1" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Alpha</sup></h3>
                    <p>Pintu 1 (Dalam)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testAD1" name="testAD1" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Beta</h3>
                    <p>Pintu 1 (Luar)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testBL1" name="testBL1" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Beta</sup></h3>
                    <p>Pintu 1 (Dalam)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testBD1" name="testBD1" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <!-- ------------------------------------------------>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>Alpha</h3>
                    <p>Pintu 2 (Luar)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testAL2" name="testAL2" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Alpha</sup></h3>
                    <p>Pintu 2 (Dalam)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testAD2" name="testAD2" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Beta</h3>
                    <p>Pintu 2 (Luar)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testBL2" name="testBL2" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                  <div class="inner">
                    <h3>Beta</sup></h3>
                    <p>Pintu 2 (Dalam)</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bug"></i>
                  </div>
                  <div class="small-box-footer">
                    <form action="test-dev" method="POST">
                      <button type="submit" id="testBD2" name="testBD2" class="btn-light btn-sm">Tap di Sini &nbsp;
                        <i class="fas fa-arrow-circle-right"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- ./col -->
            </div>
          </div>
          <!-- /.tab-pane -->

          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

  <!-- /.card TIDAK ADA-->

</section>