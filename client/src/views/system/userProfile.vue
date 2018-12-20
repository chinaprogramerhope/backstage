<template>
  <div style="text-align: center">
    <el-row>
      账号<el-input v-model="account" placeholder="" style="width:600px"/>
    </el-row>

    <el-row>
      姓名<el-input v-model="account" placeholder="" style="width:600px">
        <el-button slot="append">保存</el-button>
      </el-input>
    </el-row>

    <el-row>
      google身份验证器
      <el-button>点击绑定</el-button>
      <el-button type="primary">下载教程</el-button>
    </el-row>

    <el-row>
      手机号
      <el-input v-model="mobileNumber" placeholder="" style="width:600px">
        <el-button slot="append">绑定手机</el-button>
      </el-input>
    </el-row>

    <el-row>
      登录密码
      <el-button>修改密码</el-button>
    </el-row>

    <el-row>
      两步验证
      <el-button>未启用</el-button>
      <el-button>点击启用</el-button>
    </el-row>

    <el-row>
      上次登录<el-input v-model="account" placeholder="暂无时间记录" style="width:600px"/>
    </el-row>

    <el-row>
      本次登陆<el-input v-model="account" placeholder="暂无时间记录" style="width:600px"/>
    </el-row>
  </div>
</template>
