<template>
  <div>
    <el-form :model="form1" align="left" style="margin-left: 30px; margin-top: 30px" label-position="right" label-width="100px">

      <el-form-item label="游戏开关">
        <el-checkbox v-model="form1.gameStatus" checked>打开</el-checkbox>
      </el-form-item>

      <el-form-item label="关闭提示">
        <el-input v-model="tips" clearable style="width: 300px"/>
      </el-form-item>

      <el-form-item label="">
        <el-button v-model="tips" type="danger" size="small">提交</el-button>
      </el-form-item>

    </el-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        gameStatus: ''
      }
    }
  }
}
</script>
