import Vue from 'vue';
import './app2.js';

//=================================================
//Vue.js
//=================================================

if(!json_steplist_obj){
  var items = '';
}else{
  var items = json_steplist_obj; 
}

// register_step マイページ
var listComponent = `
<div>
  <div v-for="item in register_step" class="p-mysteplist__item">
    <a v-bind:href="'http://step0123.xsrv.jp/sample_framework03/public/temp/members/editstep?step_id='+item.id" class="p-mysteplist__link">
      <li class="c-title--small">タイトル: {{item.title}}</li> 
      <br>
      <li>カテゴリー: {{item.category}}</li><br>
      <li>目安時間: {{item.time}}</li><br>
      <li class="p-mysteplist__item--content">内容: {{item.content}}</li>
    </a>
  </div>
</div>
`

Vue.component('list-item', {
    template: listComponent,
    props: ['register_step'],
    data: function() {
      return {myList: register_step}
    },
  })

new Vue({
  el: "#appp",
  data () {
    return {
      currentPage: 0,   // 現在のページ番号
      size: 21,         // 1ページに表示するアイテムの上限
      pageRange: 10,    // ページネーションに表示するページ数の上限
      lists: items,
      searchLists: items,
      register_step: register_step,
      selected: 'すべて表示',
      selection: '',
    }
  },
  mounted () {
    // 表示するアイテムの初期化（APIで取得するなど）
    this.searchLists = [...items].map((value, i) => {
      return {
        id: value.id,
        title: value.title,
        category: value.category,
        time: value.time,
        content: value.content
      };
    });
  },
  computed: {
    /**
     * 検索フォームのデータが変化したら自動で
     * 変更を読みとって、検索処理をする
     */
    // itemsFiltered: function () {
    //   return this.findBy(this.lists, this.selected)
    // },
    /**
     * ページ数を取得する
     * @return {number} 総ページ数(1はじまり)
     */
    pages () {
      return Math.ceil(this.searchLists.length / this.size);
    },
    /**
     * ページネーションで表示するページ番号の範囲を取得する
     * @return {Array<number>} ページ番号の配列
     */
    displayPageRange () {
      const half = Math.ceil(this.pageRange / 2);
      let start, end;

      if (this.pages < this.pageRange) {
        // ページネーションのrangeよりページ数がすくない場合
        start = 1;
        end = this.pages;
      
      } else if (this.currentPage < half) {
        // 左端のページ番号が1になったとき
        start = 1;
        end = start + this.pageRange - 1;

      } else if (this.pages - half < this.currentPage) {
        // 右端のページ番号が総ページ数になったとき
        end = this.pages;
        start = end - this.pageRange + 1;

      } else {
        // activeページを中央にする
        start = this.currentPage - half + 1;
        end = this.currentPage + half;
      }
    
      let indexes = [];
      for (let i = start; i <= end; i++) {
        indexes.push(i);
      }
      return indexes;
    },
    /**
     * 現在のページで表示するアイテムリストを取得する
     * @return {any} 表示用アイテムリスト
     */
    displayItems () {
      const head = this.currentPage * this.size;
      return this.searchLists.slice(head, head + this.size);
    },
    /**
     * 現在のページかどうか判定する
     * @param {number} page ページ番号
     * @return　{boolean} 現在のページならtrue
     */
    isSelected (page) {
      return page - 1 === this.currentPage;
    }
  },
  
  methods: {
    
    /**
     * カテゴリーによる絞り込み機能を実装
     */
    findBy: function () {
        //return alert(this.selected);
        this.searchLists = this.lists;
        var selected = this.selected;
        var all = this.searchLists;
        var searchResult = this.searchLists.filter(function (item) {
        // 入力がない場合は全件表示
        //return alert(value); //itemには1つ１つのオブジェクトが格納されている
        //item.category === value;
        if(selected === 'すべて表示'){
          return item.category;
        }else{
          return item.category === selected;
        }
    })
    console.log(searchResult);
    return this.searchLists = searchResult;
    },
    /**
     * ページ先頭に移動する
     */
    first () {
      this.currentPage = 0;
      this.selectHandler();
    },
    /**
     * ページ後尾に移動する
     */
    last () {
      this.currentPage = this.pages - 1;
      this.selectHandler();
    },
    /**
     * 1ページ前に移動する
     */
    prev () {
      if (0 < this.currentPage) {
        this.currentPage--;
        this.selectHandler();
      }
    },
    /**
     * 1ページ次に移動する
     */
    next () {
      if (this.currentPage < this.pages - 1) {
        this.currentPage++;
        this.selectHandler();
      }
    },
    /**
     * 指定したページに移動する
     * @param {number} index ページ番号
     */
    pageSelect (index) {
      this.currentPage = index - 1;
      this.selectHandler();
    },
    /**
     * ページを変更したときの処理
     */
    selectHandler () {
      // なんかの処理
    }
  }
});


