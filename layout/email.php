<?php
// $toDate = date('Y-m-d');
$toDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $_SESSION["NextStartDate"] ) ) . "-1 day" ) );
$fromDate = $_SESSION["StartDate"];
$staffRole = $_SESSION['staffRole'];
if($staffRole == '99'){
  $selectStaffId = $_SESSION['staffId'];
} else {
  $selectStaffId = 'all';
}

?>
<div class="main-panel">
  <nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-minimize">
        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
          <i class="material-icons visible-on-sidebar-regular">more_vert</i>
          <i class="material-icons visible-on-sidebar-mini">view_list</i>
        </button>
      </div>
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
        Mass Email
        </a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="separator hidden-lg hidden-md"></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="card">
            <div class="card-header card-header-icon" data-background-color="black">
              <i class="material-icons-outlined">mail_outline</i>
            </div>
            <div class="card-content">
            <div>
                <h4 class="card-title">Mass Email</h4>
              </div>
              <div class="toolbar row">
                <div class="col-md-12 text-right">
                  <button type="button" class="btn btn-fill btn-info btn-sm" data-toggle="modal"
                    data-target="#newEmailModal" id="newEmail">New Email</button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 row-eq-height">
                  <label class="massMail-filter-term mg-r-10">Term:</label>
                  <label class="massMail-filter-sender mg-lr-10">Sender:</label>

                </div>
              </div>

              <div class="material-datatables">
                <table id="datatables-massMail"
                  class="table table-striped table-no-bordered table-hover display nowrap ellipsis-table"
                  cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Subject</th>
                      <th>Sender</th>
                      <th>Sent</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div><!-- end content-->
          </div><!--  end card  -->

        </div>
        <!-- end col-md-12 -->
      </div>
      <!-- end row -->
    </div>
  </div>
</div>
<?php
  include_once('layout/newEmailModal.html');
  include_once('layout/spinner.html');
?>
<script type="text/javascript">
  $(document).ready(function () {
    getParentsEmailList();
  });
</script>
