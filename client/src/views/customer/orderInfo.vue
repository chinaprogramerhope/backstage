<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="100px">

      <el-form-item label="账号id:">
        <el-input v-model="form1.account" placeholder="账号id" clearable style="width: 100px"/>
      </el-form-item>

      <el-form-item label="用户id">
        <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="订单号:">
        <el-input v-model="form1.orderId" placeholder="订单号" clearable style="width: 100px"/>
      </el-form-item>

      <el-form-item label="第三方订单号">
        <el-input v-model="form1.thirdOrderId" placeholder="第三方订单号" clearable style="width: 150px"/>
      </el-form-item>

      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.dateTimeRange"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始时间"
          end-placeholder="结束时间"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>

      <el-form-item label="支付平台:">
        <el-select v-model="form1.selectPayPlatform" style="width: 150px">
          <el-option
            v-for="item in form1.optionsPayPlatform"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="订单状态:">
        <el-select v-model="form1.selectOrderStatus" style="width: 150px">
          <el-option
            v-for="item in form1.optionsOrderStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="游戏种类:">
        <el-select v-model="form1.selectGameType" style="width: 150px">
          <el-option
            v-for="item in form1.optionsGameType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="danger" size="small" icon="el-icon-search" @click="handleGetDelay()">查询延时订单</el-button>
      </el-form-item>

    </el-form>

    <el-checkbox v-model="showPlatform" style="margin-left: 40px; margin-top: 30px;">显示支付平台</el-checkbox>
    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="userId" align="center"/>
      <el-table-column min-width="10%" prop="account" label="金额" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="充值前金币" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="充值后金币" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="订单号" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="第三方订单号" align="center"/>
      <el-table-column min-width="10%" prop="account" label="参数" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="提交时间" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="到账时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="来源" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="支付方式" align="center"/>
      <el-if show-platform>
        <el-table-column min-width="10%" prop="operation" label="支付方式" align="center"/>
      </el-if>
      <el-table-column min-width="10%" prop="operation" label="备注" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectPayPlatform: -1,
        optionsPayPlatform: [{
          label: '全部',
          value: -1
        }],

        selectOrderStatus: -1,
        optionsOrderStatus: [{
          label: '全部',
          value: -1
        }],

        selectGameType: -1,
        optionsGameType: [{
          label: '全部',
          value: -1
        }],

        accuont: '',
        userId: '',
        orderId: '',
        thirdOrderId: '',
        dateTimeRange: ''
      },

      showPlatform: false,

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
