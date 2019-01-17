<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-form-item label="账号id:">
        <el-input v-model="form1.accountId" placeholder="账号id" clearable/>
      </el-form-item>

      <el-form-item label="用户id:">
        <el-input v-model="form1.userId" placeholder="用户id" clearable/>
      </el-form-item>

      <el-form-item label="支付宝账号:">
        <el-input v-model="form1.aliPay" placeholder="支付宝账号" clearable/>
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
      :data="tableData"
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
    </el-table>

    <!-- 表格合计 -->
    <el-table
      :data="tableDataSum"
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
    </el-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        accountId: '',
        userId: '',
        aliPay: '',
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

      tableData: [{
        id: '11'
      }],

      tableDataSum: ''
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
