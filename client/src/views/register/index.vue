<template>
  <div>

    <el-form :model="form1" align="center" style="margin-top: 30px" label-position="top" label-width="80px">

      <el-form-item
        :rules="[
          { required: true, message: '请输入账号', trigger: 'blur' }
        ]"
        prop="userName"
        label="账号"
      >
        <el-input v-model="form1.userName" placeholder="4~15位限英文数字" style="width:400px" clearable auto-complete="off"/>
      </el-form-item>

      <el-form-item
        :rules="[
          { required: true, message: '请输入密码', trigger: 'blur' }
        ]"
        prop="pass"
        label="密码"
      >
        <el-input v-model="form1.pass" placeholder="6~15位限英文数字" style="width:400px" clearable auto-complete="off"/>
      </el-form-item>

      <el-form-item
        :rules="[
          { required: true, message: '请确认密码', trigger: 'blur' }
        ]"
        prop="passRepeat"
        label="确认密码"
      >
        <el-input v-model="form1.passRepeat" style="width:400px" clearable auto-complete="off"/>
      </el-form-item>

      <el-form-item
        :rules="[
          { required: true, message: '请输入验证码', trigger: 'blur' }
        ]"
        label="验证码"
        prop="verifyCodeInput"
      >
        <el-input v-model="form1.verifyCodeInput" style="width:360px" clearable auto-complete="off"/>
        {{ verifyCode }}
      </el-form-item>

      <el-form-item>
        <el-button type="primary" @click="onSubmit('form1')">确认注册</el-button>
      </el-form-item>

    </el-form>

  </div>
</template>

<script>
import { register } from '@/api/register'
import { getVerifyCode } from '@/api/register'

export default {
  data() {
    return {
      form1: {
        userName: '',
        pass: '',
        passRepeat: '',
        verifyCodeInput: ''
      },
      verifyCode: '1111'
    }
  },

  created() {
    this.$store.dispatch('closeSideBar', { withoutAnimation: false })
    this.getVerifyCodeClient()
  },

  methods: {
    getVerifyCodeClient() {
      getVerifyCode().then(response => {
        this.verifyCode = response.data['verifyCode']
        // test
        console.log('retCode = ' + this.verifyCode)
      })
    },

    onSubmit() {
      this.getVerifyCodeClient()
      register(this.form1.userName, this.form1.pass, this.form1.passRepeat, this.form1.verifyCodeInput).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '注册成功',
            message: '',
            type: 'success'
          })
        } else {
          this.$notify({
            title: '注册失败!! ' + response.data['msg'],
            message: '',
            type: 'error'
          })
        }
      })
    }

    // onSubmit(formName) {
    //   this.$refs[formName].validate((valid) => {
    //     if (valid) {
    //       register(this.form1.userName, this.form1.pass, this.form1.passRepeat, this.form1.verifyCodeInput).then(response => {
    //         if (response.code === 0) {
    //           this.$notify({
    //             title: '注册成功',
    //             message: '',
    //             type: 'success'
    //           })
    //         } else {
    //           this.$notify({
    //             title: '注册失败!! ' + response.data['msg'],
    //             message: '',
    //             type: 'error'
    //           })
    //         }
    //       })
    //     } else {
    //       this.$notify({
    //         title: '检验不通过, 请检查错误提示',
    //         message: '',
    //         type: 'warning'
    //       })
    //     }
    //   })
    // }
  }
}
</script>

