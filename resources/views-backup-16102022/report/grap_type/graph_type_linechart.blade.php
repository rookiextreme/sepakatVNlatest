<figure class="highcharts-figure" style="overflow-x:scroll;">
    <div class="inChartTitle"></div>
    <hr/>
    <div id="line_container" style="float:left;width:auto; height: 400px; margin: 0 auto"></div>
</figure>
<script type="text/javascript">

let lineTitle = '{{$title}}';
let lineSubTitle = '';
let lineData =  [];

let totalLineOthers = 0;

@if ($list)
    @foreach ($list as $item)
        @if ($loop->index <=10)
            lineData.push({
                name: '{{$item->name}}',
                y: {{$item->total}},
            });
            totalRow = totalRow + 1;
            @else
            totalLineOthers = totalLineOthers + {{$item->total}};
        @endif
    @endforeach
    lineData.push({
        name: 'SELAIN',
        y: totalLineOthers
    });
@endif

$('#line_container').css({'width':(200 + (totalRow*50) + 'px')});
$('.title-report span').text(bartitle);
$('.inChartTitle').text(bartitle);

    Highcharts.chart('line_container', {
        chart: {
        type: 'line',
        backgroundColor: 'rgba(0,0,0,0)'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: barsubTitle
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        labels: {
            style: {
                fontSize: '10px !important',
                color: '#000000'
            }
        },
        type: 'category'
    },
    yAxis: {
        labels: {
            style: {
                fontSize: '12px !important',
                color: '#000000'
            }
        },
        title: {
            text: 'Jumlah Kenderaan'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        line: {
            label : {
                maxFontSize : '10px'
            }
        },
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: false,
                format: 'Jumlah {point.y: ,.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span>',
        pointFormat: '{point.name} <br/> <b>{point.y:,.0f}</b>'
    },

    series: [
        {
            name: "",
            colorByPoint: true,
            data: bardata
        }
    ]
});

Highcharts.setOptions({
    lang: {
      thousandsSep: ','
    }
  });
</script>