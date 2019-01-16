<template>
  <div>

    <!-- 支付总开关 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>支付总开关</span></div>

      <div>
        <el-form :model="formMaster" label-position="right" label-width="100px">

          <el-form-item label="支付开关">
            <el-checkbox v-model="formMaster.paySwitch">关闭</el-checkbox>
          </el-form-item>

          <el-form-item label="人工充值">
            <el-checkbox v-model="formMaster.manPay">关闭</el-checkbox>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="submitPayMaster()">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

    <!-- 支付宝第三方 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>支付宝第三方</span></div>

      <div>
        <el-form :model="formAliThird" label-position="right" label-width="100px">

          <el-form-item label="支付宝支付渠道">
            <el-checkbox-group v-model="formAliThird.payChannel">
              <div><el-checkbox label="-1">长城云</el-checkbox></div>
              <div><el-checkbox label="1">派支付</el-checkbox></div>
              <div><el-checkbox label="2">蓉银支付</el-checkbox></div>
            </el-checkbox-group>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="submitAliThird()">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

    <!-- 支付宝官方 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>支付宝官方</span></div>

      <div>
        <el-form :model="formOfficial" label-position="right" label-width="100px">

          <el-form-item label="金额(小于等于)">
            <el-input v-model="formOfficial.amount" placeholder="0"/>
          </el-form-item>

          <el-form-item label="开关时间"/>

          <el-row :gutter="40">
            <el-col :span="6">
              <el-form-item label="开启时间:">
                <el-input v-model="formOfficial.amount" placeholder="输入0~23小时数"/>
              </el-form-item>
            </el-col>

            <el-col :span="6">
              <el-form-item label="结束时间:">
                <el-input v-model="formOfficial.amount" placeholder="输入0~23小时数"/>
              </el-form-item>
            </el-col>

            <el-col :span="6">
              <el-form-item label="(设置为相等则不会关闭)"/>
            </el-col>
          </el-row>

          <el-form-item label="支付控制"/>
          <el-form-item label="几秒内:">
            <el-input v-model="xx" placeholder="1"/>
          </el-form-item>
          <el-form-item label="支付几单:">
            <el-input v-model="xx" placeholder="1"/>
          </el-form-item>

          <el-form-item label="官方支付宝">
            <el-radio-group v-model="xx">
              <div><el-radio :label="1">不使用</el-radio></div>
              <div><el-radio :label="2">支付宝风暴网络科技</el-radio></div>
              <div><el-radio :label="3">支付宝明月网络科技</el-radio></div>
              <div><el-radio :label="4">支付宝温馨网络科技</el-radio></div>
            </el-radio-group>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="xx">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

    <!-- 微信第三方 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>微信第三方</span></div>

      <div>
        <el-form :model="formWechatThird" label-position="right" label-width="100px">

          <el-form-item label="微信支付渠道">
            <el-checkbox-group v-model="formWechatThird.payChannel">
              <div><el-checkbox label="-1">畅付</el-checkbox></div>
              <div><el-checkbox label="1">品付</el-checkbox></div>
              <div><el-checkbox label="2">聚宝云</el-checkbox></div>
            </el-checkbox-group>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="submitAliThird()">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

    <!-- QQ第三方 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>QQ第三方</span></div>

      <div>
        <el-form :model="form1" label-position="right" label-width="100px">

          <el-form-item label="QQ支付渠道">
            <el-checkbox-group v-model="formWechatThird.payChannel">
              <div><el-checkbox label="-1">ween支付</el-checkbox></div>
              <div><el-checkbox label="1">80卡云计费QQ</el-checkbox></div>
              <div><el-checkbox label="2">路易QQWAP</el-checkbox></div>
            </el-checkbox-group>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="submitAliThird()">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

    <!-- 京东钱包第三方 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>京东钱包第三方</span></div>

      <div>
        <el-form :model="form1" label-position="right" label-width="100px">

          <el-form-item label="京东支付渠道">
            <el-checkbox-group v-model="formWechatThird.payChannel">
              <div><el-checkbox label="-1">路易JD155</el-checkbox></div>
              <div><el-checkbox label="1">长城云京东</el-checkbox></div>
              <div><el-checkbox label="2">品付</el-checkbox></div>
            </el-checkbox-group>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="submitAliThird()">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

    <!-- 银联快捷支付 -->
    <el-card shadow="always">

      <div slot="header" style="color:#2E9AFE; width:100px"><span>银联快捷支付</span></div>

      <div>
        <el-form :model="form1" label-position="right" label-width="100px">

          <el-form-item label="银联快捷支付渠道">
            <el-checkbox-group v-model="formWechatThird.payChannel">
              <div><el-checkbox label="-1">海富支付</el-checkbox></div>
              <div><el-checkbox label="1">长城云银联</el-checkbox></div>
              <div><el-checkbox label="2">聚宝云</el-checkbox></div>
            </el-checkbox-group>
          </el-form-item>

          <el-form-item label="">
            <el-button type="primary" size="small" @click="submitAliThird()">提交</el-button>
          </el-form-item>

        </el-form>
      </div>

    </el-card>

  </div>
</template>

<script>
import { getDetail } from '@/api/member'
import { updateDetail } from '@/api/member'

export default {
  data() {
    return {

      form1: {
        id: '',
        userIDCardName: '',
        user_email: '',
        mobile_number: '',
        registertime: '',
        last_login_time: '',
        password: '',
        user_device_id: '',
        wallet: '',
        alipay_account: '',
        payBonusGameCount: '',
        payContribution: '',

        // 用户状态
        selectUserStatus: 1,
        optionsUserStatus: [{
          label: '正常',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        // 用户充值
        selectUserCharge: 1,
        optionsUserCharge: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        // 用户取款
        selectUserTakeMoney: 1,
        optionsUserTakeMoney: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        // 用户下注
        selectUserBet: 1,
        optionsUserBet: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        // 账户余额
        selectAccountBlance: 1,
        optionsAccountBlance: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }]
      },

      // 用户游戏信息
      tableDataUserGame: '',

      // 用户权限信息
      tableDataUserActivity: '',

      // 分页
      currentPage: 1
    }
  },

  created() {
    getDetail(this.$route.query.userId).then(response => {
      if (response.code === 0) {
        this.form1 = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {
    handleSave() {
      const userId = this.form1.id
      const realName = this.form1.userIDCardName
      const mobileNumber = this.form1.mobile_number
      const aliPayAccount = this.form1.alipay_account

      updateDetail(userId, realName, mobileNumber, aliPayAccount).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '保存成功',
            message: '',
            type: 'success'
          })
        } else {
          this.$notify({
            title: '保存失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>

