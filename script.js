google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Goiania', 'Jataí', 'Catalão', 'Goiás', 'Total'],
    ['2005',  58,   11,        9,        1,      79  ],
    ['2006',  63,   15,        14,       1,      93  ],
    ['2007',  66,   18,        16,       1,      101 ],
    ['2008',  66,   20,        19,       1,      106 ],
    ['2009',  81,   21,        24,       3,      129 ],
    ['2010',  85,   23,        25,       3,      136 ],
    ['2011',  86,   23,        25,       3,      137 ],
    ['2012',  86,   24,        25,       3,      138 ],
    ['2013',  89,   24,        25,       5,      143 ],
    ['2014',  90,   25,        26,       6,      147 ],
    ['2015',  90,   25,        26,       7,      148 ]
  ]);

  var options = {
    title: 'Testando Gráfico de Anos',
    legend: { position: 'bottom' }
  };

  var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

  chart.draw(data, options); 
}