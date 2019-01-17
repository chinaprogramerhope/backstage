<template>
  <div>

    <el-card shadow="always">

      <div>
        <div>在用Proxys(vip3):</div>
        <div>在用Proxys(vip2):</div>
        <div>在用Proxys(vip):</div>
        <div>在用Proxys(not vip):</div>
      </div>

    </el-card>

    <el-form :inline="true" :model="form1" align="left" style="margin-left: 30px; margin-top: 30px" label-position="right" label-width="100px">

      <el-form-item>
        <el-select v-model="form1.selectX" size="small" @change="handleX()">
          <el-option
            v-for="item in form1.optionsX"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item>
        <el-button type="danger" size="small">全部同步到redis</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="游戏" align="center"/>
      <el-table-column min-width="10%" prop="tag" label="tag" align="center"/>
      <el-table-column min-width="10%" prop="user_email" label="proxy ip(请用','分割)" align="center">
        <template slot-scope="scope1">
          <el-input :rows="2" v-model="x" type="textarea" placeholder=""/>
        </template>
      </el-table-column>
      <el-table-column min-width="10%" prop="isBlack" label="操作" align="center">
        <template slot-scope="scope2">
          <el-button size="mini" type="danger" @click="xx">保存</el-button>
        </template>
      </el-table-column>

    </el-table>

  </div>
</template>

<script>
import { updateDetail } from '@/api/member'

export default {
  data() {
    return {

      form1: {
        selectX: -1,
        optionsX: [{
          label: '全部',
          value: -1
        }]
      },

      tableData: [{
        id: 1
      }],

      // 分页
      currentPage: 1
    }
  },

  created() {
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

