<figure class="highcharts-figure" style="overflow-x:scroll;">
    <div class="inChartTitle"></div>
    <hr/>
    <div id="pie_container" style="min-width: 400px;width:auto; height: 400px; margin: 0 auto;"></div>
</figure>
<script type="text/javascript">

let pieTitle = '{{$title}}';
let pieSubTitle = '';
let pieData =  [];
var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];

let totalPieOthers = 0;

@if ($list)
    @foreach ($list as $item)
        @if ($loop->index <=10)
            pieData.push({
                name: '{{$item->name}}',
                y: {{$item->total}},
            });
            totalRow = totalRow + 1;
            @else
            totalPieOthers = totalPieOthers + {{$item->total}};
        @endif
    @endforeach
    pieData.push({
        name: 'SELAIN',
        y: totalPieOthers
    });
@endif
$('#bar_container').css({'width':(200 + (totalRow*50) + 'px')});
$('.title-report span').text(bartitle);
$('.inChartTitle').text(bartitle);

if(pieData.length > 0){
    pieData = _.sortBy(pieData, o => o.y).reverse();
}

    Highcharts.chart('pie_container', {
    chart: {
        backgroundColor: 'rgba(0,0,0,0)',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: "",
        colorByPoint: true,
        // data: [{name:name, y:16.49}]
        data: pieData
    }]
});
</script>
