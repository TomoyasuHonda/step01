<div id="appp">
  <h1 class="c-title">みんなのSTEP</h1>

  <div id="app" class="container">

  検索：<select v-model="selected" required>
          <option value="" disabled selected value required>Chosee</option>
          <option value="すべて表示" selected="selected">すべて表示</option>
          <option value="プログラミング">プログラミング</option>
          <option value="外国語">外国語</option>
          <option value="数学">数学</option>
          <option value="国語">国語</option>
          <option value="社会学">社会学</option>
          <option value="科学">科学</option>
          <option value="芸術">芸術</option>
          <option value="料理">料理</option>
          <option value="その他">その他</option>
      </select>
      <span>Selected: {{ selected }}</span>

      <button @click="findBy()" class="u-button__search--size">search</button>
      
      <div>
          <img src="http://tigpig.com/wp-content/2012/03/120310_1200_tigpig_bg200_200.jpg" alt="" class="p-image--fish">
      </div>
      
    <ul class="p-steplist">
          <div v-for="item in displayItems" class="u-steplist--style">
              <a v-bind:href="'http://step0123.xsrv.jp/sample_framework03/public/temp/members/detailstep?step_id='+item.id">
                  <li class="p-steplist--item">
                      <h2 class="c-title--small">{{ item.title }}</h2><br>{{ item.category }}<br>{{ item.time }}<br>{{ item.content }}<br>
                  </li>
              </a>
          </div>
    </ul>

    <nav style="margin-bottom: 200px;">
      <ul class="pagination">
        <li class="p-pagination__item">
          <a @click="first" class="page-link" href="#">&laquo;</a>
        </li>
        <li class="p-pagination__item">
          <a @click="prev" class="page-link" href="#">&lt;</a>
        </li>

        <li
          v-for="i in displayPageRange"
          class="p-pagination__item"
          :class="{active: i-1 === currentPage}">
          <a @click="pageSelect(i)" class="page-link" href="#">{{ i }}</a>
        </li>

        <li class="p-pagination__item">
          <a @click="next" class="page-link" href="#">&gt;</a>
        </li>
        <li class="p-pagination__item">
          <a @click="last" class="page-link" href="#">&raquo;</a>
        </li>
      </ul>
    </nav>
  </div>

</div>

<script type="text/javascript">

  var register_step;

  var json_steplist = '<?php echo $list; ?>';//PHPからJSON形式のデータを取得

  var json_steplist_new = json_steplist.replace(/(\r\n)/g, '\n')
    .replace(/(\r)/g,   '\n')
    .replace(/(\n)/g,  '\\n')
    .replace(/&quot;/g,'"');//正しいJSON形式にする

  var json_steplist_obj = JSON.parse(json_steplist_new);//JSONデータをJSオブジェクトに変換

</script>

