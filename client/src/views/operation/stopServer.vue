<template>
  <div>
    <el-form
      :model="form1"
      align="left"
      label-position="right"
      label-width="100px"
      style="margin-left: 30px; margin-top: 30px"
    >

      <el-form-item label="游戏">
        <el-select v-model="form1.selectX">
          <el-option
            :v-for="item in form1.optionsX"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="密码">
        <el-input v-model="form1.pass"/>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" @click="onSubmit()">提交</el-button>
      </el-form-item>

    </el-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectX: -1,
        optionsX: [{
          label: '全部',
          value: -1
        }],
        pass: ''
      }
    }
  }
}
</script>

