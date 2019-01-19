<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-form-item label="用户id:">
        <el-input v-model="form1.userId" placeholder="用户id" clearable/>
      </el-form-item>

      <el-form-item label="账号id:">
        <el-input v-model="form1.accountId" placeholder="账号id" clearable/>
      </el-form-item>

      <el-form-item label="支付宝账号:">
        <el-input v-model="form1.aliPayAccount" placeholder="支付宝账号" clearable/>
      </el-form-item>

      <el-form-item label="支付宝姓名:">
        <el-input v-model="form1.aliPayName" placeholder="支付宝姓名" clearable/>
      </el-form-item>

      <el-form-item label="mac:">
        <el-input v-model="form1.mac" placeholder="mac" clearable/>
      </el-form-item>

      <el-form-item label="ip:">
        <el-input v-model="form1.ip" placeholder="ip" clearable/>
      </el-form-item>

      <el-form-item label="绑定手机:">
        <el-input v-model="form1.bindPhone" placeholder="绑定手机" clearable/>
      </el-form-item>

      <el-form-item label="是否充值:">
        <el-select v-model="form1.selectIsRecharge">
          <el-option
            v-for="item in form1.optionsIsRecharge"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" @click="handleReset()">重置</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGetMax()">金豆+保险箱最大的</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData1"
      stripe
      height="600"
      style="width: 100%; margin-bottom: 20px"
    >

      <el-table-column label="用户id" fixed="left" align="center">
        <el-table-column label="内容" prop="id"/>
      </el-table-column>
      <el-table-column label="用户id" align="center">
        <el-table-column label="操作">
          <template scope="scope">
            <el-row style="margin-bottom:20px">
              <el-button type="text" size="mini">踢出</el-button>
            </el-row>
            <el-row>
              <el-button type="text" size="mini">封充值</el-button>
            </el-row>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="昵称" align="center">
        <el-table-column label="内容" prop="nickname"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="密码" align="center">
        <el-table-column label="内容" prop="password"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="注册时间" align="center">
        <el-table-column label="内容" prop="registertime"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="账号" align="center">
        <el-table-column label="内容" prop="user_email"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">封账号</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="性别" align="center">
        <el-table-column label="内容" prop="user_sex"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="最后登录ip" align="center">
        <el-table-column label="内容" prop="lastLoginIp"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="最后登录时间" align="center">
        <el-table-column label="内容" prop="last_login_time"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="mac" align="center">
        <el-table-column label="内容" prop="mac" />
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">封mac</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="赢次数" align="center">
        <el-table-column label="内容" prop="win_game"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="输次数" align="center">
        <el-table-column label="内容" prop="lose_game"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="平均数" align="center">
        <el-table-column label="内容" prop="draw_game"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="设备id" align="center">
        <el-table-column label="内容" prop="user_device_id"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="支付宝账号" align="center">
        <el-table-column label="内容" prop="alipay_account"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改db</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="支付宝实名" align="center">
        <el-table-column label="内容" prop="alipay_real_name"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-row style="margin-bottom:20px">
              <el-button type="text" size="mini">修改db</el-button>
            </el-row>
            <el-row>
              <el-button type="text" size="mini">封提现</el-button>
            </el-row>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="绑定手机" align="center">
        <el-table-column label="内容" prop="boundmobilenumber"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改db</el-button>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="ip" align="center">
        <el-table-column label="内容" prop="ip"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">封ip</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="总付费" align="center">
        <el-table-column label="内容" prop="totalBuy"/>
        <el-table-column label="操作"/>
      </el-table-column>
      <el-table-column label="总提现" align="center">
        <el-table-column label="内容" prop="total_total_money"/>
        <el-table-column label="操作"/>
      </el-table-column>
      <el-table-column label="渠道号" align="center">
        <el-table-column label="内容" prop="channel_id"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="激活设备" align="center">
        <el-table-column label="内容" prop="activate_device"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="钻石数量" align="center">
        <el-table-column label="内容" prop="secondmoney"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改db</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="是否被举报" align="center">
        <el-table-column label="内容" prop="is_reported"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="金币数" align="center">
        <el-table-column label="内容" prop="user_chips"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="记牌器" align="center">
        <el-table-column label="内容" prop="notecarddeviceeffectivetime"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="保险箱" align="center">
        <el-table-column label="内容" prop="cofferchips"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="保险箱密码" align="center">
        <el-table-column label="内容" prop="cofferpassword"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改db</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="炮台等级" align="center">
        <el-table-column label="内容" prop="gunindex"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="冰冻卡数量" align="center">
        <el-table-column label="内容" prop="skill1num"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="锁定卡数量" align="center">
        <el-table-column label="内容" prop="skill2num"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="充值贡献度" align="center">
        <el-table-column label="内容" prop="payContribution"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="周期净分(捕鱼)" align="center">
        <el-table-column label="内容" prop="periodwinscore"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="周期游戏次数(捕鱼)" align="center">
        <el-table-column label="内容" prop="periodgamecount"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="日净分(捕鱼)" align="center">
        <el-table-column label="内容" prop="dailywinscore"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="总玩分(捕鱼)" align="center">
        <el-table-column label="内容" prop="totalplayscore"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="总赢分(捕鱼)" align="center">
        <el-table-column label="内容" prop="totalwinscore"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="总发射次数(捕鱼)" align="center">
        <el-table-column label="内容" prop="totalshotcount"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="日发射次数(捕鱼)" align="center">
        <el-table-column label="内容" prop="dailyshotcount"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="强发库(捕鱼)" align="center">
        <el-table-column label="内容" prop="forcepool"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="奖励库(捕鱼)" align="center">
        <el-table-column label="内容" prop="rewardpool"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="待增加" align="center">
        <el-table-column label="内容"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="待增加" align="center">
        <el-table-column label="内容"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="待增加" align="center">
        <el-table-column label="内容"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column label="电话号码" align="center">
        <el-table-column label="内容" prop="mobile_number"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="连续登录" align="center">
        <el-table-column label="内容" prop="consecutive_login"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-tag type="warning" size="mini">禁止</el-tag>
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column label="用户图片" align="center">
        <el-table-column label="内容" prop="user_avatar_url"/>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button type="text" size="mini">修改</el-button>
          </template>
        </el-table-column>
      </el-table-column>

      <el-table-column prop="dbIndex" label="数据库索引" align="center"/>
      <el-table-column prop="tableIndex" label="表索引" align="center"/>
      <el-table-column prop="black_des" label="被封原因" align="center"/>
      <el-table-column prop="versionstatus" label="版本查询" align="center"/>

      <el-table-column prop="recordTime" label="比赛相关信息" align="center"/>
      <el-table-column prop="userIDCardName" label="姓名" align="center"/>
      <el-table-column prop="userIDCard" label="身份证" align="center"/>
      <el-table-column prop="mobile_number" label="电话" align="center"/>

    </el-table>

    <!-- 表格2 -->
    <!-- <el-table
      :data="tableData2"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="gameName" label="游戏名称" align="center"/>
      <el-table-column min-width="10%" prop="account" label="在线时间" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="总玩次数" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="累积赢分" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="累积输分" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="累积净分" align="center"/>
      <el-table-column min-width="10%" prop="account" label="累计服务费" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="真实净分" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="最近一天净分" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="首玩时间查询" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="版本查询" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="最近游戏时间" align="center"/>
    </el-table> -->

    <!-- 表格3 -->
    <!-- <el-table
      :data="tableData3"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="gameName" label="总在线时间" align="center"/>
      <el-table-column min-width="10%" prop="account" label="总玩次数" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="总赢分" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="总输分" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="总净分" align="center"/>
      <el-table-column min-width="10%" prop="account" label="总服务费" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="总真实净分" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="游戏首玩时间查询" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="玩家游戏版本查询" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="最近一天总净分" align="center"/>
    </el-table> -->

    <!-- dialog1 -->
    <!-- <el-dialog :visible.sync="dialogForm1Visible" title="" center>
      <el-form ref="dialogForm1" :model="dialogForm1">

        <el-form-item :label-width="dialogForm1.form1LabelWidth" label="游戏状态:">
          <el-select v-model="dialogForm1.selectStatus" placeholder="">
            <el-option
              v-for="item in dialogForm1.optionsStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogForm1Visible = false">取 消</el-button>
          <el-button type="primary" @click="handleDialog1Save">保 存</el-button>
        </el-form-item>
      </el-form>

    </el-dialog> -->
  </div>
</template>

<script>
import { userDetailGet } from '@/api/customer'
import { userDetailGetMax } from '@/api/customer'

export default {
  data() {
    return {
      form1: {
        accountId: '',
        userId: '',
        aliPayAccount: '',
        aliPayName: '',
        mac: '',
        ip: '',
        bindPhone: '',
        selectIsRecharge: -1,
        optionsIsRecharge: [{
          label: '全部',
          value: -1
        }, {
          label: '是',
          value: 1
        }, {
          label: '否',
          value: 2
        }]
      },

      tableData1: '',

      tableData2: '',

      tableData3: ''
    }
  },

  created() {
    const accountId = this.form1.accountId
    const userId = this.form1.userId
    const aliPayAccount = this.form1.aliPayAccount
    const aliPayName = this.form1.aliPayName

    const mac = this.form1.mac
    const ip = this.form1.ip
    const bindPhone = this.form1.bindPhone
    const isRecharge = this.form1.selectIsRecharge

    userDetailGet(accountId, userId, aliPayAccount, aliPayName, mac, ip, bindPhone, isRecharge).then(response => {
      if (response.code === 0) {
        this.tableData1 = response.data
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

    // 查询
    handleGet() {
      const accountId = this.form1.accountId
      const userId = this.form1.userId
      const aliPayAccount = this.form1.aliPayAccount
      const aliPayName = this.form1.aliPayName

      const mac = this.form1.mac
      const ip = this.form1.ip
      const bindPhone = this.form1.bindPhone
      const isRecharge = this.form1.selectIsRecharge

      userDetailGet(accountId, userId, aliPayAccount, aliPayName, mac, ip, bindPhone, isRecharge).then(response => {
        if (response.code === 0) {
          this.tableData1 = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 金豆+保险箱最大的
    handleGetMax() {
      userDetailGetMax().then(response => {
        if (response.code === 0) {
          alert(JSON.stringify(response.data['cofee']))
          alert(JSON.stringify(response.data['jindu']))
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>
