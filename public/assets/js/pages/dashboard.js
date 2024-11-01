! function(r) {
    "use strict";

    function e() {}
    e.prototype.createDonutChart = function(e, a, r) {
        Morris.Donut({
            element: e,
            data: a,
            barSize: .2,
            resize: !0,
            colors: r,
            backgroundColor: "transparent"
        })
    }, e.prototype.init = function() {

		var $chart = this;
        setChart($chart);
        
    }, r.MorrisCharts = new e, r.MorrisCharts.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.MorrisCharts.init()
}();

function setChart($this) {
    $baseUrl = $("#baseUrl").val();
    $.ajax({
        type: 'POST',
        url: $baseUrl + '/admin/dashboard/data',
        data: {
            '_token' : $('#token').val(),
            'range': $("#range-datepicker").val()
        },
        dataType: 'json',
        success: function(response) {
            var $data = [];
			var $chartContainer = $("#payment-chart");
            var $noData = '<p style="position:absolute;top:45%;left:43%;" >No data available</p>';

            if(response.status = 'success') {
                $.each(response.payment, function(index, value) {
                    var $payment = {};
                    $payment["label"] = index;
                    $payment["value"] = value; 
                    $data.push($payment);
                });

				var $colors = ["#1abc9c", "#4fc6e1", "#f7b84b"];
				$chartContainer.empty();
				$this.createDonutChart("payment-chart", $data, $colors);
                $data.length === 0 ? $chartContainer.empty().html($noData) : '';
            }
            
            $(".payment-spinner").remove();
        },
        error: function(error) {
            $(".payment-spinner").remove();
            errorHandler(error);
        }
    });
}