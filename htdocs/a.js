var data = [{
  x: ['１月','２月','３月','４月','５月','６月','７月'],
  y: [65, 59, 80, 81, 56, 55, 48],
  tvar ,data = [
    {
     value: 300,
     color:"#F7464A",
     highlight: "#FF5A5E",
     label: "Red"
    },
    {
     value: 50,
     color: "#46BFBD",
     highlight: "#5AD3D1",
     label: "Green"
    },
    {
     value: 100,
     color: "#FDB45C",
     highlight: "#FFC870",
     label: "Yellow"
    }
   ],
   
   var: myChart = new Chart(document.getElementById("mycanvas").getContext("2d")).Doughnut(data),type: 'pie'
}];
var options = {
  title: 'サンプルチャート'
};

Plotly.plot('stage', data, options);