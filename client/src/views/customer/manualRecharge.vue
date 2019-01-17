<template>
  <div>
    <el-form
      :model="form1"
      :label-position="right"
      label-width="120px"
      style="margin-left: 10px; margin-top: 30px;"
    >
      <el-form-item label="用户id">
        <el-input v-model="form1.userId" placeholder="请输入用户id" clearable style="width: 400px"/>
      </el-form-item>

      <el-form-item label="确认用户id">
        <el-input v-model="form1.userIdConfirm" placeholder="请输入用户id" clearable style="width: 400px"/>
      </el-form-item>

      <el-form-item label="第三方订单号">
        <el-input v-model="form1.thirdOrderId" placeholder="没有请留空" clearable style="width: 400px"/>
      </el-form-item>

      <el-form-item label="充值金额">
        <el-input v-model="form1.amount" placeholder="请输入金额, 必须为正整数, 单位'元'" clearable style="width: 400px"/>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="mini">提交</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        userId: '',
        userIdConfirm: '',
        thirdOrderId: '',
        amount: ''
      }
    }
  }
}
</script>

