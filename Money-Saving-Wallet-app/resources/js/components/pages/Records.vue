<template>
  <div class="container">
    <h4>Incomes</h4>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div v-for="(record, index) of records" :key="index">
        <Item v-bind:record="record" v-bind:index="index" v-on:remove="remove">
        </Item>
      </div>
      <paginate
        :page-count="pageCount"
        :page-range="3"
        :margin-pages="2"
        :click-handler="clickCallback"
        :prev-text="'Prev'"
        :next-text="'Next'"
        :container-class="'pagination'"
        :page-class="'page-item'"
        :page-link-class="'page-link'"
        :prev-class="'page-item'"
        :prev-link-class="'page-link'"
        :next-class="'page-item'"
        :next-link-class="'page-link'"
      >
      </paginate>
    </div>
  </div>
</template>

<script>
import Item from "../cards/RecordItem.vue";

export default {
  mounted() {
    console.log("Records Component mounted.");
    this.user_id = localStorage.user_id;
    console.log("this.user_id" + this.user_id);
    this.$parent.checkLogin();
    axios
      .get("http://127.0.0.1:8000/api/records?user_id=" + this.user_id)
      .then((response) => {
        this.loading = false;
        this.records = response.data.data;
        this.posts = response.data;
        this.pageCount = this.posts.last_page;
        console.log("records" + JSON.stringify(this.records));
      });
  },
  components: {
    Item,
  },
  data: function () {
    return {
      records: [],
      current_page: 1,
      totalPages: 10,
      posts: [],
      pageCount: 0,
      user_id: 0,
      loading: true,
    };
  },
  methods: {
    remove: function (index) {
      this.records.splice(index, 1);
      this.$forceUpdate();
    },
    pageChangeHandler(selectedPage) {
      this.currentPage = selectedPage;
    },
    updateResource(data) {
      this.records = data;
    },
    clickCallback(pageNum) {
      axios
        .get(
          "http://127.0.0.1:8000/api/records?user_id=" +
            this.user_id +
            "&page=" +
            pageNum
        )
        .then((response) => {
          this.records = response.data.data;
        });
    },
  },
};
</script>
