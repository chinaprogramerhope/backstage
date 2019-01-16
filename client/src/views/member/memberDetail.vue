<template>
  <div>
    <el-form :model="form1" label-position="right" label-width="100px">

      <el-card shadow="always">
        <div slot="header" style="color:#2E9AFE; width:100px"><span>用户基础信息</span></div>
        <div>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="用户ID:" required>
                <el-input v-model="form1.id" readonly/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="上级:">
                <el-input v-model="form1.up" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">

              <el-form-item label="用户等级">
                <el-select v-model="form1.selectUserLv" placeholder="" disabled>
                  <el-option
                    v-for="item in form1.optionsUserLv"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

            <el-col :span="8">
              <el-form-item label="真实姓名:" required>
                <el-input v-model="form1.userIDCardName" clearable/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">

              <el-form-item label="用户状态">
                <el-select v-model="form1.selectUserStatus" placeholder="">
                  <el-option
                    v-for="item in form1.optionsUserStatus"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

            <el-col :span="8">
              <el-form-item label="E-mail:">
                <el-input v-model="form1.user_email" clearable/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="手机号码:" required>
                <el-input v-model="form1.mobile_number" clearable/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="微信号码:">
                <el-input v-model="form1.wechat" clearable/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="QQ号码:">
                <el-input v-model="form1.qq" clearable/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="账户id:">
                <el-input v-model="form1.user_email" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="注册时间:">
                <el-input v-model="form1.registertime" readonly/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="最后登录时间:">
                <el-input v-model="form1.last_login_time" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="密码:">
                <el-input v-model="form1.password" readonly/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="资金密码:">
                <el-input v-model="form1.moneyPassword" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">

              <el-form-item label="用户标签">
                <el-select v-model="form1.selectUserTag" placeholder="" clearable>
                  <el-option
                    v-for="item in form1.optionsUserTag"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

            <el-col :span="8">

              <el-form-item label="设备唯一标识码">
                <el-select v-model="form1.selectUserDeviceId" placeholder="" disabled>
                  <el-option
                    v-for="item in form1.optionsUserDeviceId"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

          </el-row>

          <el-row>

            <el-col :span="12">
              <el-form-item label="备注:">
                <el-input v-model="form1.userId" :rows="2" type="textarea"/>
              </el-form-item>
            </el-col>

          </el-row>

        </div>
      </el-card>

      <el-card shadow="always">
        <div slot="header" style="color:#2E9AFE; width:100px"><span>账户信息</span></div>
        <div>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="账户余额:">
                <el-input v-model="form1.wallet" readonly/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="保险箱余额:">
                <el-input v-model="form1.safeBoxBalance" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="支付宝:" required>
                <el-input v-model="form1.alipay_account" clearable/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="银行卡:">
                <el-input v-model="form1.bankCard" placeholder="不包含空格" clearable/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="银行名称:">
                <el-input v-model="form1.bankName" clearable/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="充值次数:">
                <el-input v-model="form1.payBonusGameCount" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="充值金额:">
                <el-input v-model="form1.payContribution" readonly/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="提现次数:">
                <el-input v-model="form1.withdrawalTimes" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">
              <el-form-item label="提现金额:">
                <el-input v-model="form1.withdrawalAmount" readonly/>
              </el-form-item>
            </el-col>

            <el-col :span="8">
              <el-form-item label="返水金额:">
                <el-input v-model="form1.fanShuiAmount" readonly/>
              </el-form-item>
            </el-col>

          </el-row>

        </div>
      </el-card>

      <el-card shadow="always">
        <div slot="header" style="color:#2E9AFE; width:100px"><span>用户权限设置</span></div>
        <div>
          <el-row :gutter="40">

            <el-col :span="8">

              <el-form-item label="用户充值:">
                <el-select v-model="form1.selectUserCharge" placeholder="">
                  <el-option
                    v-for="item in form1.optionsUserCharge"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

            <el-col :span="8">

              <el-form-item label="用户取款">
                <el-select v-model="form1.selectUserTakeMoney" placeholder="">
                  <el-option
                    v-for="item in form1.optionsUserTakeMoney"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

          </el-row>

          <el-row :gutter="40">

            <el-col :span="8">

              <el-form-item label="用户下注">
                <el-select v-model="form1.selectUserBet" placeholder="">
                  <el-option
                    v-for="item in form1.optionsUserBet"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

            <el-col :span="8">

              <el-form-item label="账户余额:">
                <el-select v-model="form1.selectAccountBlance" placeholder="">
                  <el-option
                    v-for="item in form1.optionsAccountBlance"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>

            </el-col>

          </el-row>

        </div>
      </el-card>

      <el-card shadow="always">
        <div slot="header" style="color:#2E9AFE; width:100px"><span>用户游戏信息</span></div>
        <div>
          <el-table
            :data="tableDataUserGame"
            :default-sort="{prop: 'userIDCardName', order:'descending'}"
            stripe
            style="width: 75%; margin-bottom: 20px">
            <el-table-column min-width="10%" prop="gameName" label="游戏" align="center"/>
            <el-table-column min-width="10%" prop="total_competition_times" label="游戏次数" align="center"/>
            <el-table-column min-width="10%" prop="winLose" label="输赢" align="center"/>
            <el-table-column min-width="15%" prop="lastPlayTime" label="最后游戏时间" align="center"/>
            <el-table-column min-width="10%" prop="" label="操作" align="center">
              <template slot-scope="scope">
                <el-button size="mini" @click="handleGet()">查询</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-card>

      <el-card shadow="always">
        <div slot="header" style="color:#2E9AFE; width:100px"><span>用户活动信息</span></div>
        <div>
          <el-table
            :data="tableDataUserActivity"
            :default-sort="{prop: 'userIDCardName', order:'descending'}"
            stripe
            style="width: 75%; margin-bottom: 20px">
            <el-table-column min-width="10%" prop="time" label="时间" align="center"/>
            <el-table-column min-width="10%" prop="lastLoginIp" label="IP" align="center"/>
            <el-table-column min-width="10%" prop="location" label="地址" align="center"/>
            <el-table-column min-width="10%" prop="operation" label="行为" align="center"/>
            <el-table-column min-width="10%" prop="deviceName" label="设备" align="center"/>
          </el-table>
        </div>
      </el-card>

      <el-card shadow="always">
        <div>

          <el-row :gutter="40">

            <el-col :span="6">
              <router-link :to="'/member/memberList'">
                <el-button type="primary" size="mini">返回</el-button>
              </router-link>
            </el-col>

            <el-col :span="6">
              <el-button type="primary" @click="handleSave()">保存</el-button>
            </el-col>

          </el-row>

        </div>
      </el-card>

    </el-form>
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

