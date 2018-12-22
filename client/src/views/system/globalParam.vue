<template>
  <div>
    <el-form :model="form1" style="margin-top: 30px;" align="center">
      <el-form-item>
        <el-row>
          <el-col :span="8">参数名称</el-col>
          <el-col :span="8">设置</el-col>
          <el-col :span="8">功能描述</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">注册验证码</el-col>
          <el-col :span="8">
            <el-radio v-model="form1.radio" label="1">图形验证码</el-radio>
            <el-radio v-model="form1.radio" label="2">手机验证码</el-radio>
          </el-col>
          <el-col :span="8">改变注册界面验证码的生成方式</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">在线客服连接</el-col>
          <el-col :span="8"><el-input v-model="form1.customerUrl" placeholder="请输入URL地址" style="width:600px"/></el-col>
          <el-col :span="8">在线客服链接地址配置</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">管理员人工充值额度上限值</el-col>
          <el-col :span="8"><el-input v-model="form1.maxCharge" placeholder="请输入金额, 最大输入99万" style="width:600px"/></el-col>
          <el-col :span="8">管理员每日人工充值额度上限值，0点重置</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">管理员人工提现额度上限值</el-col>
          <el-col :span="8"><el-input v-model="form1.withdrawalMax" placeholder="请输入金额, 最大输入99万" style="width:600px"/></el-col>
          <el-col :span="8">管理员人工提现额度上限值，0点重置</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">提现方式开关</el-col>
          <el-col :span="8">
            <el-checkbox-group v-model="form1.withdrawalMethod">
              <el-checkbox label="银行卡"/>
              <el-checkbox label="支付宝"/>
            </el-checkbox-group>
          </el-col>
          <el-col :span="8">显示/隐藏用户的提现方式</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">APP端启动页消息设置</el-col>
          <el-col :span="8">
            <el-input v-model="form1.message" placeholder="" style="width:500px"/>
            <el-button type="primary" circle>+</el-button>
          </el-col>
          <el-col :span="8">随机选择已设置的消息展示在APP启动页面</el-col>
        </el-row>
      </el-form-item>

      <el-form-item>
        <el-row>
          <el-col :span="8">提示音设置</el-col>
          <el-col :span="16">
            <el-table
              :data="form1.tableData"
              :default-sort="{prop: 'timeBegin', order:'descending'}"
              style="width: 100%; margin-bottom: 24px"
              stripe
            >
              <el-table-column prop="soundProject" label="提示音项目" align="center"/>
              <el-table-column prop="currentSound" label="当前声音" align="center"/>
              <el-table-column prop="enableSound" label="启用声音" align="center">
                <template slot-scope="scope">
                  <el-switch
                    v-model="form1.switchEnableSound"
                    active-text="开启"
                    inactive-text="关闭"
                  />
                </template>
              </el-table-column>
              <el-table-column prop="operation" label="操作" align="center">
                <template slot-scope="scope">
                  <el-button type="primary" size="mini" @click="handleUpload()">上传</el-button>
                  <el-button type="danger" size="mini" @click="handleReset()">重置</el-button>
                </template>
              </el-table-column>
            </el-table>
          </el-col>
        </el-row>
      </el-form-item>

      <el-form-item align="center">
        <el-button type="primary" @click="handleSubmit()">保存</el-button>
      </el-form-item>

    </el-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        radio: '1',
        customerUrl: '',
        maxCharge: '',
        withdrawalMax: '',
        withdrawalMethod: ['银行卡'],
        message: '',
        switchEnableSound: '',
        tableData: [{
          soundProject: '2018-11-11 11:11:11'
        }, {
          soundProject: '2018-11-11 11:11:11'
        }]
      }
    }
  }
}
</script>
