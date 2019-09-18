<?php
include APPPATH . '/modules/views/header.php';
$dataPoints = array();
foreach ($daily_data as $value) {
    $dataPoints[$value['day']] = $value['total'];
}
if ($month != '' || $year != '') {
    if ($month != '' && $year != '') {
        if ($month == date('m') && $year == date('Y')) {
            $current_days = unixtojd(mktime(0, 0, 0, 6, date('d')));
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
            $total_days = $total_days - ($total_days - cal_from_jd($current_days, CAL_GREGORIAN)['day']);
        } else {
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
    } elseif ($month != '') {
        if ($month == date('m')) {
            $current_days = unixtojd(mktime(0, 0, 0, 6, date('d')));
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
            $total_days = $total_days - ($total_days - cal_from_jd($current_days, CAL_GREGORIAN)['day']);
        } else {
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
        }
    } elseif ($year != '') {
        $total_days = cal_days_in_month(CAL_GREGORIAN, date('m'), $year);
    }
} else {
    $total_days = cal_days_in_month(CAL_GREGORIAN, date('m') - 1, date('Y'));
}
for ($i = 1; $i <= $total_days; $i++) {
    if (!array_key_exists($i, $dataPoints)) {
        $dataPoints[$i] = 0;
    }
}
ksort($dataPoints);
foreach ($dataPoints as $key => $val) {
    $chartContainer_label[] = $key;
    $chartContainer_view[] = $val;
    $max_article = max($chartContainer_view);
}
?>
<script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>Chart.min.js"></script>
<style>
    .select-wrapper span.caret {
        top: 18px;
        color: black;
    }
    .select-wrapper input.select-dropdown {
        color: black;
    }
</style>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-4">
                            <form action="<?php echo base_url('reports'); ?>" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="kb-select initialized" name="month">
                                            <option value="">Select Month</option>
                                            <option value='1' <?php echo isset($month) && $month == '1' ? 'selected' : ''; ?>>Janaury</option>
                                            <option value='2' <?php echo isset($month) && $month == '2' ? 'selected' : ''; ?>>February</option>
                                            <option value='3' <?php echo isset($month) && $month == '3' ? 'selected' : ''; ?>>March</option>
                                            <option value='4' <?php echo isset($month) && $month == '4' ? 'selected' : ''; ?>>April</option>
                                            <option value='5' <?php echo isset($month) && $month == '5' ? 'selected' : ''; ?>>May</option>
                                            <option value='6' <?php echo isset($month) && $month == '6' ? 'selected' : ''; ?>>June</option>
                                            <option value='7' <?php echo isset($month) && $month == '7' ? 'selected' : ''; ?>>July</option>
                                            <option value='8' <?php echo isset($month) && $month == '8' ? 'selected' : ''; ?>>August</option>
                                            <option value='9' <?php echo isset($month) && $month == '9' ? 'selected' : ''; ?>>September</option>
                                            <option value='10' <?php echo isset($month) && $month == '10' ? 'selected' : ''; ?>>October</option>
                                            <option value='11' <?php echo isset($month) && $month == '11' ? 'selected' : ''; ?>>November</option>
                                            <option value='12' <?php echo isset($month) && $month == '12' ? 'selected' : ''; ?>>December</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="kb-select initialized" name="year">
                                            <option value="">Select Year</option>
                                            <?php
                                            if (isset($year_data) && count(array_filter($year_data)) > 0) {
                                                $min = $year_data['min'];
                                                $max = $year_data['max'];
                                                for ($i = $min; $i <= $max; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>" <?php echo isset($year) && $year == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="<?php echo date('Y'); ?>" <?php echo isset($year) && $year == date('Y') ? 'selected' : ''; ?>><?php echo date('Y'); ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-search-plus"></i></button>
                                        <button class="btn btn-danger" type="button" onclick="window.location.href = '<?php echo base_url('reports'); ?>'"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card p-4">
                            <div style="width:100%;">
                                <h3 class="text-center">Monthly Post View</h3>
                                <canvas id="canvas"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<script>
    // article chart
    var canvas = document.getElementById('canvas');
    var data = {
        labels: <?php echo json_encode($chartContainer_label, JSON_NUMERIC_CHECK); ?>,
        datasets: [
            {
                label: "Views",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: <?php echo json_encode($chartContainer_view, JSON_NUMERIC_CHECK); ?>,
            }
        ]
    };

    function adddata() {
        myLineChart.data.datasets[0].data[7] = 60;
        myLineChart.data.labels[7] = "Newly Added";
        myLineChart.update();
    }

    var option = {
        showLines: true,
        scales: {
            xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                }],
            yAxes: [{
                    display: true,
                    ticks: {
                        min: 0,
                        max: <?php echo isset($max_article) && $max_article > 5 ? $max_article : 5; ?>,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Post Views'
                    }

                }]
        }
    };
    var myLineChart = Chart.Line(canvas, {
        data: data,
        options: option
    });
</script>
<?php include APPPATH . '/modules/views/footer.php'; ?>