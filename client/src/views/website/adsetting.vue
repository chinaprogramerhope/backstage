<template>
  <div>

    <e-form v-model="form1">

      <el-form-item>
        棋牌游戏顶部
        <el-upload
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          :file-list="fileList2"
          class="upload-demo"
          action="https://jsonplaceholder.typicode.com/posts/"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
        </el-upload>
      </el-form-item>

      <el-form-item>
        捕鱼游戏顶部
        <el-upload
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          :file-list="fileList2"
          class="upload-demo"
          action="https://jsonplaceholder.typicode.com/posts/"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
        </el-upload>
      </el-form-item>

      <el-form-item>
        电玩游戏顶部
        <el-upload
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          :file-list="fileList2"
          class="upload-demo"
          action="https://jsonplaceholder.typicode.com/posts/"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
        </el-upload>
      </el-form-item>

      <el-form-item>
        优惠活动顶部
        <el-upload
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          :file-list="fileList2"
          class="upload-demo"
          action="https://jsonplaceholder.typicode.com/posts/"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
        </el-upload>
      </el-form-item>

      <el-form-item>
        <el-button type="primary">保存</el-button>
      </el-form-item>

    </e-form>

  </div>

</template>

<script>
export default {
  data() {
    return {
      form1: {

      },
      fileList2: []
    }
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList)
    },
    handlePreview(file) {
      console.log(file)
    }
  }
}
</script>
