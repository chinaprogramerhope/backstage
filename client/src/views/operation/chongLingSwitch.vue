<template>
  <div>

    <el-form
      :inline="true"
      :model="formChong"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-form-item label="'充'开关">
        <el-checkbox v-model="formChong.checked">关闭</el-checkbox>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="small" @click="handleChong()">提交</el-button>
      </el-form-item>

    </el-form>

    <el-form
      :inline="true"
      :model="formLing"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-form-item label="'领'开关">
        <el-checkbox v-model="formLing.checked">关闭</el-checkbox>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" size="small" @click="handleLing()">提交</el-button>
      </el-form-item>

    </el-form>

  </div>
</template>

<script>
export default {
  data() {
    return {
      formChong: {
        checked: false
      },

      formLing: {
        checked: false
      }
    }
  }
}
</script>

