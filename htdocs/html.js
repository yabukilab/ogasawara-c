var ctx = document.getElementById("PieChart");
var win = document.getElementsByClassName("win").textContent //クラス名winから値を取得(A学園)
var lose = document.getElementsByClassName("lose").textContent //クラス名loseから値を取得(B学園)
var winnum = document.getElementsByClassName("win-rate").textContent  //クラス名win-rateから値を取得(60)
var PieChart = new Chart(ctx, {
  type: 'pie', //グラフのタイプは円グラフです、という意味
  data: {
    labels: [win,lose], //円グラフのラベル(円グラフのA学園,B学園と表示されている箇所)
    datasets: [{
      backgroundColor: [ //円グラフの色
        "#FF0000", //1つめの色(ラベルwin)は赤
        "#33CCFF", //2つめの色(ラベルlose)は水色
      ],
      data: [winnum,100-winnum] //グラフの値 下記参照
    }]
  },
  options: { //オプションでカスタマイズ？
    title: {
      display: true,
      text: '勝利確率'//グラフのタイトル
    }
  }
});