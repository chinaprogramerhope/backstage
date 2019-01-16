<template>

  <div>
    <el-container>
      <el-main>

        <!-- 表单 -->
        <el-form :model="form1" style="margin-bottom: 10px; margin-top: 20px;" label-position="right" label-width="100px">
          <el-row :gutter="20">

            <el-col :span="6"><el-form-item label="用户ID"><el-input v-model="form1.id" placeholder="用户ID" clearable/></el-form-item></el-col>

            <el-col :span="6">
              <el-form-item label="会员状态">
                <el-select v-model="form1.selectVipStatus" placeholder="会员状态" disabled>
                  <el-option
                    v-for="item in form1.optionsVipStatus"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :span="6">
              <el-form-item label="会员等级">
                <el-select v-model="form1.selectVipLv" placeholder="会员等级" disabled>
                  <el-option
                    v-for="item in form1.optionsVipLv"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>

            <el-col :span="6"><el-form-item label="上级"><el-input placeholder="上级账号" disabled/></el-form-item></el-col>

          </el-row>

          <el-row :gutter="20">

            <el-col :span="7">
              <el-form-item label="注册日期">
                <el-date-picker
                  v-model="form1.dateRange"
                  type="daterange"
                  range-separator="~"
                  start-placeholder="开始日期"
                  end-placeholder="结束日期"
                  value-format="yyyy-MM-dd HH:mm:ss"
                  style="width:250px"
                />
              </el-form-item>
            </el-col>

            <el-col :span="6">
              <el-form-item label="玩家状态">
                <el-select v-model="form1.selectUserStatus" placeholder="请选择" clearable disabled>
                  <el-option
                    v-for="item in form1.optionsUserStatus"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>

            <!-- <el-col :span="3"><el-form-item><el-button @click="onSubmit">更多条件</el-button></el-form-item></el-col>

            <el-col :span="3"><el-form-item><el-button @click="onSubmit">+新增</el-button></el-form-item></el-col> -->

            <el-col :span="3"><el-form-item><el-button type="primary" icon="el-icon-search" @click="onGetList">查询</el-button></el-form-item></el-col>

          </el-row>

          <el-row :gutter="20">

            <el-col :span="6"><el-form-item label="账号ID"><el-input v-model="form1.userEmail" placeholder="" clearable/></el-form-item></el-col>

            <el-col :span="6"><el-form-item label="手机号码"><el-input v-model="form1.mobileNumber" placeholder="" clearable/></el-form-item></el-col>

            <el-col :span="6"><el-form-item label="支付宝姓名"><el-input v-model="form1.realName" placeholder="" clearable/></el-form-item></el-col>

            <el-col :span="6"><el-form-item label="支付宝账号"><el-input v-model="form1.aliPayAccount" placeholder="" clearable/></el-form-item></el-col>

          </el-row>

        </el-form>

        <!-- 表格 -->
        <el-table
          :data="tableData"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          stripe
          style="width: 100%; margin-bottom: 20px">
          <el-table-column min-width="10%" prop="online" label="在线" align="center"/>
          <el-table-column min-width="10%" prop="id" label="用户id" align="center"/>
          <el-table-column min-width="15%" prop="user_email" label="账号id" align="center"/>
          <el-table-column min-width="10%" prop="userIDCardName" label="真实姓名" align="center"/>
          <el-table-column min-width="10%" prop="upLine" label="上级" align="center"/>
          <el-table-column min-width="10%" prop="downLineNum" label="下级人数" align="center"/>
          <el-table-column min-width="15%" prop="registertime" label="注册日期" align="center" sortable/>
          <el-table-column min-width="10%" prop="isBlack" label="状态" align="center">
            <template slot-scope="scope">
              <div v-if="1">
                <el-tag size="small" type="success" @click="xx">启用</el-tag>
              </div>
              <div v-else>
                <el-tag size="small" type="danger" @click="xx">禁用</el-tag>
              </div>
            </template>
          </el-table-column>
          <el-table-column min-width="10%" prop="balance" label="账户余额" align="center"/>
          <el-table-column min-width="10%" prop="userStatus" label="玩家状态" align="center">
            <template slot-scope="scope">
              <div v-if="1">
                <el-tag size="small" type="success" @click="xx">在线</el-tag>
              </div>
              <div v-else>
                <el-tag size="small" type="danger" @click="xx">离线</el-tag>
              </div>
            </template>
          </el-table-column>
          <el-table-column min-width="15%" prop="operation" label="操作" align="center">
            <template slot-scope="scope">
              <el-row :gutter="40">
                <el-col :span="6">
                  <!-- <router-link :to="'/member/memberDetail'"> -->
                  <router-link :to="{path:'/member/memberDetail', query:{userId:scope.row.id}}">
                    <el-button type="primary" size="mini" @click="handleDetail()">详情</el-button>
                  </router-link>
                </el-col>
                <el-col :span="6">
                  <div v-if="scope.row.status==='黑名单'">
                    <el-button size="mini" type="success" @click="handleDetail()">启用</el-button>
                  </div>
                  <div v-else>
                    <el-button size="mini" type="danger" @click="handleDetail()">禁用</el-button>
                  </div>
                </el-col>
              </el-row>

            </template>
          </el-table-column>
        </el-table>

        <!-- 分页 -->
        <!-- <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          align="center"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        /> -->

      </el-main>
    </el-container>
  </div>
</template>

<script>
import { getList } from '@/api/member'

export default {
  data() {
    return {

      form1: {
        id: '',
        selectVipStatus: '',
        selectVipLv: '',
        date: '',
        userEmail: '',
        mobileNumber: '',
        realName: '',
        aliPayAccount: '',
        selectUserStatus: '',
        optionsVipStatus: [{
          label: '全部',
          value: 'all'
        }, {
          label: '启用',
          value: 'open'
        }, {
          label: '禁用',
          value: 'close'
        }],
        optionsVipLv: [],
        optionsUserStatus: [{
          label: '在线',
          value: 'online'
        }, {
          label: '离线',
          value: 'offline'
        }]
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 1
    }
  },

  created() {
    const dateRange = this.form1.dateRange
    const userId = this.form1.id
    const isOnline = this.form1.isOnline
    const userEmail = this.form1.userEmail
    const mobileNumber = this.form1.mobileNumber
    const realName = this.form1.realName
    const aliPayAccount = this.form1.aliPayAccount

    getList(dateRange, userId, isOnline, userEmail, mobileNumber, realName, aliPayAccount).then(response => {
      if (response.code === 0) {
        this.tableData = response.data
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
    onGetList() {
      const dateRange = this.form1.dateRange
      const userId = this.form1.id
      const isOnline = this.form1.isOnline
      const userEmail = this.form1.userEmail
      const mobileNumber = this.form1.mobileNumber
      const realName = this.form1.realName
      const aliPayAccount = this.form1.aliPayAccount

      getList(dateRange, userId, isOnline, userEmail, mobileNumber, realName, aliPayAccount).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    },

    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
