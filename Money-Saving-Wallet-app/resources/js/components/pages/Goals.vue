<template>
  <div class="container">
    <h4>Expenses</h4>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <div v-for="(goal, index) of goals" :key="index">
        <Item v-bind:goal="goal" v-bind:index="index" v-on:remove="remove">
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
import Item from "../cards/GoalItem.vue";

export default {
  mounted() {
    console.log("Goals Component mounted.");
    this.user_id = localStorage.user_id;
    console.log("this.user_id" + this.user_id);
    this.$parent.checkLogin();
    axios
      .get("http://127.0.0.1:8000/api/goals?user_id=" + this.user_id)
      .then((response) => {
        this.loading = false;
        this.goals = response.data.data;
        this.posts = response.data;
        this.pageCount = this.posts.last_page;
        console.log("goals" + JSON.stringify(this.goals));
      });
  },
  components: {
    Item,
  },
  data: function () {
    return {
      goals: [],
      current_page: 1,
      totalPages: 10,
      resource_url: "http://127.0.0.1:8000/api/goals",
      posts: [],
      pageCount: 0,
      user_id: 0,
      loading: true,
    };
  },
  methods: {
    remove: function (index) {
      this.goals.splice(index, 1);
      this.$forceUpdate();
    },
    pageChangeHandler(selectedPage) {
      this.currentPage = selectedPage;
    },
    updateResource(data) {
      this.goals = data;
    },
    clickCallback(pageNum) {
      axios
        .get(
          "http://127.0.0.1:8000/api/goals?user_id=" +
            this.user_id +
            "&page=" +
            pageNum
        )
        .then((response) => {
          this.goals = response.data.data;
          this.posts = response.data;
        });
    },
  },
};
</script>
