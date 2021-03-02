## Japan Meteorological Agency

気象庁のウェブサイトから情報を取得するスクリプト。
※ PHP でスクレイピングする

<br><br>

#### 気象庁ウェブサイト HTML ソース

(https://www.jma.go.jp/jp/yoho/346.html)

```
<table class="forecast" id="forecasttablefont">
  <caption style="text-align:left;">4日17時福岡管区気象台発表の天気予報(今日4日から明後日6日まで)</caption>
  <tbody>
    <tr>
      <th colspan="2" class="th-area"><div style="float: left">福岡地方</div></th>
      <th class="th-rain">降水確率</th>
      <th class="th-temp">気温予報</th>
    </tr>
    <tr>
      <th class="weather">今夜4日<br><img src="img/700.png" align="middle" title="晴れ" alt="晴れ"><br></th>
      <td class="info">北の風　晴れ<br>波　１．５メートル　後　２メートル　うねり　を伴う</td>
      <td class="rain">
        <div class="font-size-clear">
          <table class="rain">
            <tbody>
              <tr>
                <td align="left">00-06</td>
                <td align="right">--%</td>
              </tr>
              <tr>
                <td align="left">06-12</td>
                <td align="right">--%</td>
              </tr>
              <tr>
                <td align="left">12-18</td>
                <td align="right">--%</td>
              </tr>
              <tr>
                <td align="left">18-24</td>
                <td align="right">0%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
      <td class="temp">
        <div class="font-size-clear">
          <table class="temp">
            <tbody>
              <tr>
                <th></th>
                <th nowrap="">朝の最低</th>
                <th nowrap="">日中の最高</th>
              </tr>
              <tr>
                <td class="city">福岡</td>
                <td class="min">1度</td>
                <td class="max">13度</td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <th class="weather">明日5日<br><img src="img/112.png" align="middle" title="晴れ後一時雨" alt="晴れ後一時雨"><br></th>
      <td class="info">南東の風　後　西の風　海上　では　南西の風　やや強く　晴れ　後　くもり　夜遅く　雨<br>波　２メートル　後　１．５メートル　うねり　を伴う</td>
      <td class="rain">
        <div class="font-size-clear">
          <table class="rain">
            <tbody>
              <tr>
                <td align="left" nowrap="">00-06</td>
                <td align="right">0%</td>
              </tr>
              <tr>
                <td align="left" nowrap="">06-12</td>
                <td align="right">0%</td>
              </tr>
              <tr>
                <td align="left" nowrap="">12-18</td>
                <td align="right">10%</td>
              </tr>
              <tr>
                <td align="left" nowrap="">18-24</td>
                <td align="right">50%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
      <td class="temp">
        <div class="font-size-clear">
          <table class="temp">
            <tbody>
              <tr>
                <th></th>
                <th nowrap="">朝の最低</th>
                <th nowrap="">日中の最高</th>
              </tr>
              <tr>
                <td class="city">福岡</td>
                <td class="min">1度</td>
                <td class="max">13度</td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
```

<br><br>

#### 気象庁アイコン

| Code | Weather                     |
| ---- | --------------------------- |
| 100  | 晴れ                        |
| 101  | 晴れ時々曇り (晴れ一時曇り) |
| 102  | 晴れ時々雨 (晴れ一時雨)     |
| 104  | 晴れ時々雪 (晴れ一時雪)     |
| 110  | 晴れ後曇り (晴れ後一時曇り) |
| 112  | 晴れ後雨 (晴れ後一時雨)     |
| 115  | 晴れ後雪 (晴れ後一時雪)     |
| 200  | 曇り                        |
| 201  | 曇り時々晴れ (曇り一時晴れ) |
| 202  | 曇り時々雨 (曇り一時雨)     |
| 204  | 曇り時々雪 (曇り一時雪)     |
| 210  | 曇り後晴れ (曇り後一時晴れ) |
| 212  | 曇り後雨 (曇り後一時雨)     |
| 215  | 曇り後雪 (曇り後一時雪)     |
| 300  | 雨                          |
| 301  | 雨時々晴れ (雨一時晴れ)     |
| 302  | 雨時々曇り (雨一時曇り)     |
| 303  | 雨時々雪 (雨一時雪)         |
| 308  | 大雨 (???)                  |
| 311  | 雨後晴れ (雨後一時晴れ)     |
| 313  | 雨後曇り (雨後一時曇り)     |
| 314  | 雨後雪 (雨後一時雪)         |
| 400  | 雪                          |
| 401  | 雪時々晴れ (雪一時晴れ)     |
| 402  | 雪時々曇り (雪一時曇り)     |
| 403  | 雪時々雨 (雪一時雨)         |
| 406  | 吹雪 (???)                  |
| 411  | 雪後晴れ (雪後一時晴れ)     |
| 413  | 雪後曇り (雪後一時曇り)     |
| 414  | 雪後雨 (雪後一時雨)         |
| 700  | 晴れ (夜)                   |
| 701  | 晴れ時々曇り (夜)           |
| 702  | 晴れ時々雨 (夜)             |
| 703  | 晴れ時々雪 (夜)             |
| 704  | 曇時々晴れ (夜)             |
| 705  | 雨時々晴れ (夜)             |
| 706  | 雪時々晴れ (夜)             |
| 707  | 晴れ後曇り (夜)             |
| 708  | 晴れ後雨 (夜)               |
| 709  | 晴れ後雪 (夜)               |
| 710  | 曇り後晴れ (夜)             |
| 711  | 雨後晴れ (夜)               |
| 712  | 雪後晴れ (夜)               |

<br><br>

#### # 天気パターン (10 つ)

| ID  | Weather                                                             |
| --- | ------------------------------------------------------------------- |
| 1   | 晴れ: 100, 700,                                                     |
| 2   | 曇り: 200,                                                          |
| 3   | 雨: 300, 308,                                                       |
| 4   | 雪: 400, 406,                                                       |
| 5   | 晴れのち曇り / 曇りのち晴れ: 101, 110, 201, 210, 701, 704 707, 710, |
| 6   | 晴れのち雨 / 雨のち晴れ: 102, 112, 301, 311, 702, 705 708, 711,     |
| 7   | 晴れのち雪 / 雪のち晴れ: 104, 115, 401, 411, 703, 706, 709, 712     |
| 8   | 曇りのち雨 / 雨のち曇り: 202, 212, 302, 313,                        |
| 9   | 曇りのち雪 / 雪のち曇り: 204, 215, 402, 413,                        |
| 10  | 雨のち雪 / 雪のち雨: 303, 314, 403, 414                             |
