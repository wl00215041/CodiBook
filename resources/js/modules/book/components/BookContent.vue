<template>
  <div id="bootCentent">
    <div class="row">
      <div
        class="col-md-3 scrollbar embed-responsive embed-responsive-16by9"
        id="style-10"
        v-if="!fullMode"
      >
        <div class="embed-responsive-item">
          <div class="action">
            <Button
              @click="switchEditable"
              icon="ios-download-outline"
              type="primary"
            >{{ (editable) ? 'Save & Exit' : 'Edit' }}</Button>
            <Button icon="ios-download-outline" type="primary" @click="open3">Load from CodiMD</Button>
            <Dropdown @on-click="setPublic" style="margin-left: 10px;">
              <Button type="primary">
                {{ (isPublic) ? 'Public' : 'Private' }}
                <Icon type="ios-arrow-down"></Icon>
              </Button>
              <DropdownMenu slot="list">
                <DropdownItem name="public">Public</DropdownItem>
                <DropdownItem name="private">Private</DropdownItem>
              </DropdownMenu>
            </Dropdown>

            <a v-if="isPublic" class="btn" :href="publicLink" target="_blank">Public Link</a>
          </div>
          <mavon-editor
            :toolbarsFlag="false"
            :language="language"
            :subfield="false"
            :defaultOpen="'preview'"
            :boxShadow="false"
            v-model="book.markdown"
          />
        </div>
      </div>
      <div
        :class="{'col-md-9': !fullMode, 'col-md-12': fullMode}"
        class="embed-responsive embed-responsive-16by9"
      >
      <div class="embed-responsive-item">
        <mavon-editor
          style="z-index:50;"
          @save="updateMarkdown"
          v-if="editable"
          :language="language"
          :defaultOpen="'edit'"
          :s_edit="true"
          v-model="book.markdown"
        />
        <iframe
          v-show="!editable"
          class="embed-responsive-item"
          ref="codimdIframe"
          id="codimdIframe"
          name="codimdIframe"
          width="90%"
          src="https://codimd.promise.com.tw"
        ></iframe>
        </div>
      </div>
    </div>
    <Affix v-if="false" :offset-bottom="5">
      <span>
        <i-switch v-model="fullMode"/>
      </span>
    </Affix>
  </div>
</template>

<script>
import Vue from "vue";
window.Vue = require("vue");
import mavonEditor from "mavon-editor";
import "mavon-editor/dist/css/index.css";
Vue.use(mavonEditor);
export default {
  mounted() {
    this.getBook();
  },
  data() {
    return {
      book: { markdown: "" },
      editable: false,
      isPublic: false,
      language: "en",
      dismissSecs: 5,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      fullMode: false,
      codimdUrl: ""
    };
  },
  methods: {
    getBook() {
      axios
        .get("/books/" + this.$route.params.id)
        .then(res => {
          this.book.markdown = res.data.markdown !== null && res.data.markdown || "";
          this.isPublic = res.data.is_public;
        })
        .catch(res => (this.book.markdown = "Not Found or No Permission"));
    },
    setPublic(isPublic) {
      axios
        .put("/books/" + this.$route.params.id, {
          data: {
            isPublic: isPublic
          }
        })
        .then(res => {
          this.isPublic = isPublic == "public" ? true : false;
        });
    },
    switchEditable() {
      if (this.editable) this.updateMarkdown();
      this.editable = !this.editable;
    },
    updateMarkdown() {
      let submitData = {
        data: {
          markdown: this.book.markdown
        }
      };
      axios
        .put("/books/" + this.$route.params.id, submitData)
        .then(res => this.$Message.success("Update successful"));
    },
    switchMode() {
      this.fullMode = !this.fullMode;
    },
    open3() {
      this.$Modal.confirm({
        render: h => {
          return h("Input", {
            props: {
              value: this.codimdUrl,
              autofocus: true,
              placeholder: "Please enter CodiMD Url..."
            },
            on: {
              input: val => {
                this.codimdUrl = val;
              }
            }
          });
        },
        onOk: async () => {
          console.log(this);
          await this.$store
            .dispatch("books/getTOC", this.codimdUrl)
            .then(result => {
              this.codimdUrl = '';
              this.book.markdown = this.book.markdown + "\n" + result.data;
            });
        }
      });
    }
  },
  computed: {
    publicLink() {
      return "/public#/public/book/" + this.$route.params.id;
    }
  }
};
</script>

<style>
.action {
  margin-left: 10px;
  margin-bottom: 10px;
}
.scrollbar {
  float: left;
  overflow-y: scroll;
  margin-bottom: 25px;
}

#style-10::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #f5f5f5;
  border-radius: 10px;
}

#style-10::-webkit-scrollbar {
  width: 10px;
  background-color: #f5f5f5;
}

#style-10::-webkit-scrollbar-thumb {
  background-color: #aaa;
  border-radius: 10px;
  background-image: -webkit-linear-gradient(
    90deg,
    rgba(0, 0, 0, 0.2) 25%,
    transparent 25%,
    transparent 50%,
    rgba(0, 0, 0, 0.2) 50%,
    rgba(0, 0, 0, 0.2) 75%,
    transparent 75%,
    transparent
  );
}
.ivu-select-dropdown {
  z-index: 2000;
}
</style>