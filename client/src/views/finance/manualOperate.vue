<template>
  <div>
    <el-container>
      <el-main>
        <el-row style="text-align: right; margin-bottom:10px; margin-top: 20px;">
          <el-button type="primary">人工存款记录</el-button>
          <el-button type="primary">人工提款记录</el-button>
        </el-row>

        <el-form ref="form" :model="form" :label-position="right" label-width="80px">
          <el-form-item label="账号:" style="width:600px">
            <el-input v-model="form.vipAccount" placeholder="请输入会员账号" >
              <el-button slot="append" icon="el-icon-search" @click="onSubmit">查找</el-button>
            </el-input>
          </el-form-item>
          <el-form-item label="会员ID:" style="width:600px">
            <el-input v-model="form.vipId" placeholder="请输入会员id">
              <el-button slot="append" icon="el-icon-search" @click="onSubmit">查找</el-button>
            </el-input>
          </el-form-item>
          <el-form-item label="金额:" style="width:600px">
            <el-input v-model="form.amount" placeholder="请输入金额:"/>
          </el-form-item>

          <el-form-item label="类型:">
            <el-radio-group v-model="form.type">
              <el-radio label="人工存款"/>
              <el-radio label="优惠活动"/>
              <el-radio label="人工提款"/>
              <el-radio label="误存提款"/>
              <el-radio label="行政提款"/>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="备注:" style="width:600px">
            <el-input v-model="form.desc" type="textarea" placeholder="请输入备注"/>
          </el-form-item>
          <el-form-item>
            <el-button>取消</el-button>
            <el-button type="primary" @click="onSubmit">提交</el-button>
          </el-form-item>
        </el-form>
      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        vipAccount: '',
        vipId: '',
        amount: '',
        type: '',
        desc: ''
      }
    }
  },
  methods: {
    onSubmit() {
      console.log('submit!')
    }
  }
}
</script>
